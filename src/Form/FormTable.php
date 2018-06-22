<?php
/**
 * Created by PhpStorm.
 * User: Vitalik
 * Date: 18.09.2017
 * Time: 13:25
 */

namespace Trafik8787\LaraCrud\Form;

use App;

use Illuminate\Http\Request;
use Validator;
use Trafik8787\LaraCrud\Contracts\Component\TabsInterface;
use Trafik8787\LaraCrud\Contracts\Component\UploadFileInterface;
use Trafik8787\LaraCrud\Form\Component\ComponentManagerBuilder;
use Trafik8787\LaraCrud\Form\Component\File;


/**
 * Class FormTable
 * @package Trafik8787\LaraCrud\Form
 */
class FormTable extends FormManagerTable
{

    private $tabs;
    private $file;
    private $request;
    protected $validator;
    protected $relation_to_many;

    /**
     * FormTable constructor.
     * @param TabsInterface $tabs
     * @param UploadFileInterface $file
     * @param Request $request
     */
    public function __construct(TabsInterface $tabs, UploadFileInterface $file, Request $request)
    {
        $this->tabs = $tabs;
        $this->file = $file;
        $this->request = $request;
    }

    /**
     * @param null $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     */
    public function renderFormEdit($id = null)
    {

        if ($this->objConfig->getButtonEdit() === false) {
            return redirect()->back();
        }
        /**
         * если запрос пришел от поля SELECT2
         */
        if ($this->request->ajax() and csrf_token() == $this->request->get('_token')) {
            return $this->returnDataAjaxForSelect();
        }


        // todo два возможных источника ключа либо с роутера либо с метода getFormShow() если нужно вывести форму сразу
        if ($id !== null) {
            $this->id = $id;
            $formActionUrl = url()->current() . '/' . $id . '/edit';
        } else {
            $this->id = $this->admin->route->parameters['adminModelId'];
            $formActionUrl = url()->current();
        }

        $data = [
            'keyName' => $this->admin->KeyName, //name primary Key
            'id' => $this->id,
            'formActionUrl' => $formActionUrl,
            'urlAction' => $this->admin->route->parameters['adminModel'],
            'titlePage' => $this->objConfig->getTitle(),
            'buttonApply' => $this->objConfig->getButtonApply(),
            'formMetod' => 'PATCH',
            'objField' => $this->getFieldRender(),
            'classForm' => $this->objConfig->getClassForm(),
            'addViewCustom' => $this->objConfig->setViewsCustomTop($this->getModelData())
        ];

//        dump($this->admin);
        return view('lara::Form.form', $data);
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     */
    public function renderFormInsert()
    {

        if ($this->objConfig->getButtonAdd() === false) {
            return redirect()->back();
        }
        /**
         * если запрос пришел от поля SELECT2
         */
        if ($this->request->ajax() and csrf_token() == $this->request->get('_token')) {
            return $this->returnDataAjaxForSelect();
        }

        $data = [
            'urlAction' => $this->admin->route->parameters['adminModel'],
            'formActionUrl' => url()->current(),
            'titlePage' => $this->objConfig->getTitle(),
            'buttonApply' => $this->objConfig->getButtonApply(),
            'formMetod' => 'POST',
            'objField' => $this->getFieldRender(),
            'classForm' => $this->objConfig->getClassForm(),
            'addViewCustom' => $this->objConfig->setViewsCustomTop($this->objConfig->getModelObj())
        ];

        return view('lara::Form.form', $data);
    }

    /**
     * @return mixed
     * получаем запись для редактирования
     */
    public function getModelData()
    {
        return $this->objConfig->getModelObj()->find($this->id);
    }


    /**
     * @return array
     * todo должен возвращать масив с отрендеренными tamplate component
     */
    public function getFieldRender()
    {
        /**
         * добавляем в класс Tabs обьект конфигурации
         */
        $this->tabs->objConfig($this->objConfig);

        $model = $this->getModelData();

        $result = [];

        foreach ($this->getArrayField() as $item) {

            //todo получаем данные из таблицы многие ко многим для вывода в поле
            $this->objConfig->getCurentValueMultiple($item['field'], $model);
            $this->objConfig->getCurentValueOneToMany($item['field'], $model);

            //конструктор форм
            $objBilder = (new ComponentManagerBuilder($item));
            $objBilder->classStyle();
            $objBilder->type();
            $objBilder->label();
            $objBilder->placeholder();
            $objBilder->title();
            $objBilder->name();
            $objBilder->enableEditor();
            $objBilder->multiple();
            $objBilder->options();
            $objBilder->tooltip();
            $objBilder->OneToMany();
            $objBilder->required();

            $model_field_value = !empty($model->{$item['field']}) ? $model->{$item['field']} : null;

            $objBilder->value($this->objConfig->getValue($item['field'], $model_field_value));


            $result[] = $objBilder->build();
        }


        /**
         * hooks before render edit
         */

        $result = $this->objConfig->SetBeforeShowFormCollback($model, $result);

        $result = $this->tabs->build($result);


        return $result;
    }


    /**
     * @param File $file
     * @return \Illuminate\Http\RedirectResponse
     * todo метод срабатывает при обновлении
     */
    public function updateForm()
    {

        $arr_request = $this->FormRequestModelSave('update');

        if (!empty($arr_request['save_button'])) {
            return redirect('/' . config('lara-config.url_group') . '/' . $this->admin->route->parameters['adminModel']);
        }

        return redirect()->back()->withErrors($this->validator)->exceptInput();
    }


    /**
     * @return \Illuminate\Http\RedirectResponse
     * todo метод срабатывает при добавлении
     */
    public function insertForm()
    {

        $arr_request = $this->FormRequestModelSave('insert');

        if (!empty($arr_request['save_button'])) {
            return redirect('/' . config('lara-config.url_group') . '/' . $this->admin->route->parameters['adminModel']);
        }

        return redirect()->back()->withErrors($this->validator)->exceptInput();
    }


    /**
     * @param $type
     * @return mixed
     */
    public function FormRequestModelSave($type)
    {
        $model = [];
        //конфиг добавляем в класс и возвращаем масив полей
        $arr_request = $this->file->objConfig($this->objConfig);

        $nameColumn = $this->objConfig->nameColumns();

        //для обновления
        if ($type === 'update') {

            $model = $this->objConfig->getModelObj()->find($arr_request[$this->admin->KeyName]);

            unset($arr_request['_method']);
            unset($arr_request['_token']);

            //для добавления
        } elseif ($type === 'insert') {

            $model = $this->objConfig->getModelObj();
            unset($arr_request['_token']);
        }

        //валидация
        if ($this->RuleValidation($arr_request) !== true) {
            return false;
        }

        foreach ($arr_request as $name => $item) {

            if ($this->objConfig->getOneToMany($name) and $type === 'update')
            {
                $arrId = $this->saveRelationTableOneToMany($name, $item, $model);
                $item = json_encode($arrId);

            } elseif ($this->objConfig->getOneToMany($name) and $type === 'insert') {
                $this->relation_to_many[$name] = $item;
            }

            /**
             * заполняем поля модели
             */
            if (!empty($nameColumn[$name])) {
                $model->{$name} = is_array($item) ? json_encode($item) : $item;
            }
        }

        if (!empty($this->relation_to_many)) {
            /**
             * hooc after Insert
             */
            $model::created(function ($value) {

                foreach ($this->relation_to_many as $name => $item) {
                    $arrId = $this->saveRelationTableOneToMany($name, $item, $value);
                }

            });
        }

        $model->save();

        //сохранить отношение многие ко многим
        $this->saveRelationTable($arr_request, $model);
        //сохранить отношение один ко многим

        return $arr_request;
    }


    /**
     * @param $arr_request
     * @return bool|\Illuminate\Validation\Validator
     */
    public function RuleValidation($arr_request)
    {
        if ($this->objConfig->getValidationRule() !== null) {
            $this->validator = Validator::make($arr_request, $this->objConfig->getValidationRule(), $this->objConfig->getValidationMessage());

            if ($this->validator->passes()) {
                return true;
            }

            return $this->validator;
        }
        return true;
    }

    /**
     * @return string
     * todo формируем ответ с данными для поля SELECT2
     */
    public function returnDataAjaxForSelect()
    {
        $new_data = [];
        $data = $this->objConfig->getObjClassSelectAjax($this->request->input('field'));

        $model = $this->objConfig->setAjaxBeforeLoadSelect($data['model'], $this->request);
        $model = $model->where($data['select'], 'like', '%' . $this->request->input('term') . '%')->limit(10)->select($data['id'], $data['select']);
        $result = $model->get()->toArray();

        foreach ($result as $item) {
            $new_data[] = ['id' => [$item[$data['id']]], 'text' => strip_tags($item[$data['select']])];
        }
        // 'pagination' => ['more' => true]]
        return json_encode(['results' => $new_data]);

    }


    /**
     * @param $arr_request
     * @param $model
     * todo метод сохраняет в промежуточную таблицу
     */
    public function saveRelationTable($arr_request, $model)
    {
        foreach ($arr_request as $fieldName => $item) {
            $data = $this->objConfig->getCurentValueMultiple($fieldName, $model);
            if ($data !== false) {
                $data->ManyToMany()->sync($item);
            }
        }
    }

    /**
     * @param $arr_request
     * @param $model
     * todo сохраняем в таблицу отношения один ко многим
     */
    public function saveRelationTableOneToMany($fieldName, $item, $model)
    {

        //преобразование масива перед сохранением в связаную таблицу
        $item = $this->ConvertArrayRelationTable($fieldName, $item);

        $data = $this->objConfig->getCurentValueOneToMany($fieldName, $model);
        if ($data !== false) {
            //получаем первичный ключ связанной таблицы
            $primary_key = App::make($data->class)->getKeyName();
            //получаем данные из таблицы только id выбираем
            $item_id = [];

            if (!empty($item)) {
                foreach ($item as $rows) {
                    $item_id[] = (int)isset($rows[$primary_key]) ? $rows[$primary_key] : null;
                }
            }

            $data_table_id = $this->getArrIdKeyTableOneToMany($data, $primary_key);

            //получаем масив ключей которые нужно удалить
            $deleteItem = array_diff($data_table_id, $item_id);

            if (!empty($deleteItem)) {
                $data->OneToMany()->whereIn($primary_key, $deleteItem)->delete();
            }

            if (!empty($item)) {
                foreach ($item as $itemArr) {
                    //находим id
                    if (!empty($itemArr[$primary_key]) and $itemArr[$primary_key] !== null) {
                        $id = $itemArr[$primary_key];
                        unset($itemArr[$primary_key]);
                        $data->OneToMany()->find($id)->update($itemArr);
                    } else {
                        unset($itemArr[$primary_key]);
                        $ret = $data->OneToMany()->createMany([$itemArr]);
                    }

                }
            }

        }

        return $this->getArrIdKeyTableOneToMany($data, $primary_key) ?? null;
    }


    /**
     * @param $data
     * @param $primary_key
     * @return mixed
     */
    public function getArrIdKeyTableOneToMany($data, $primary_key)
    {
        return $data->OneToMany()->get([$primary_key])->map(function ($item, $key) use ($primary_key) {
            return $item->{$primary_key};
        })->toArray();
    }

}