<?php
/**
 * Created by PhpStorm.
 * User: Vitalik
 * Date: 18.09.2017
 * Time: 13:25
 */

namespace Trafik8787\LaraCrud\Form;

use Illuminate\Http\Request;
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

    /**
     * FormTable constructor.
     * @param TabsInterface $tabs
     * @param UploadFileInterface $file
     * @param Request $request
     */
    public function __construct (TabsInterface $tabs, UploadFileInterface $file, Request $request) {
        $this->tabs = $tabs;
        $this->file = $file;
        $this->request = $request;
    }
    /**
     * @param string $form = edit|insert
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function renderFormEdit ($id = null) {

        /**
         * если запрос пришел от поля SELECT2
         */
        if ($this->request->ajax() and csrf_token() == $this->request->get('_token')) {
            return $this->returnDataAjaxForSelect();
        }


        // todo два возможных источника ключа либо с роутера либо с метода getFormShow() если нужно вывести форму сразу
        if ($id !== null) {
            $this->id = $id;
            $formActionUrl = url()->current().'/'.$id.'/edit';
        } else {
            $this->id = $this->admin->route->parameters['adminModelId'];
            $formActionUrl = url()->current();
        }

        $data = [
          'keyName' => $this->admin->KeyName, //name primary Key
          'id' => $this->id,
          'formActionUrl' => $formActionUrl ,
          'urlAction' => $this->admin->route->parameters['adminModel'],
          'titlePage'  => $this->objConfig->getTitle(),
          'formMetod' => 'PATCH',
          'objField' => $this->getFieldRender()
        ];

//        dump($this->admin);
        return view('lara::Form.form', $data);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function renderFormInsert ()
    {
        $data = [
            'urlAction' => $this->admin->route->parameters['adminModel'],
            'titlePage'  => $this->objConfig->getTitle(),
            'formMetod' => 'POST',
            'objField' => $this->getFieldRender()
        ];

        return view('lara::Form.form', $data);
    }

    /**
     * @return mixed
     */
    public function getModelData () {
        return $this->objConfig->getModelObj()->find($this->id);
    }


    /**
     * @return array
     * todo должен возвращать масив с отрендеренными tamplate component
     */
    public function getFieldRender ()
    {
        /**
         * добавляем в класс Tabs обьект конфигурации
         */
        $this->tabs->objConfig($this->objConfig);

        $model = $this->getModelData();
//        $we = $model->OneToMany->find(1);
//        dump($we->number_phone = 55555555);
//        $we->save();
//        foreach ($we as $item) {
//            dump($item->mobile);
//        }


        $result = [];

        foreach ($this->getArrayField() as $item) {

            $model_field_value = null;
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



                if (!empty($model->{$item['field']})) {
                    $model_field_value = $model->{$item['field']};
                }
              //  dump($this->objConfig->getValue($item['field'], $model_field_value));
                $objBilder->value($this->objConfig->getValue($item['field'], $model_field_value));

           // $result[] = $objBilder->build()->run();
            $result[] = $objBilder->build();
        }
        $result = $this->tabs->build($result);

        return $result;
    }


    /**
     * @param File $file
     * @return \Illuminate\Http\RedirectResponse todo метод срабатывает при обновлении
     * todo метод срабатывает при обновлении
     */
    public function updateForm ()
    {

        $arr_request = $this->FormRequestModelSave('update');

        if (!empty($arr_request['save_button'])) {
            return redirect('/' . config('lara-config.url_group') . '/' . $this->admin->route->parameters['adminModel']);
        }

        return redirect()->back();
    }


    /**
     * @return \Illuminate\Http\RedirectResponse
     * todo метод срабатывает при добавлении
     */
    public function insertForm ()
    {

        $arr_request = $this->FormRequestModelSave('insert');

        if (!empty($arr_request['save_button'])) {
            return redirect('/' . config('lara-config.url_group') . '/' . $this->admin->route->parameters['adminModel']);
        }

        return redirect()->back();
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

        foreach ($arr_request as $name => $item) {
            if (!empty($nameColumn[$name])) {
                $model->{$name} = $item;
            }
        }
        $model->save();

        return $arr_request;
    }


    /**
     * @return string
     * todo формируем ответ с данными для поля SELECT2
     */
    public function returnDataAjaxForSelect ()
    {
        $new_data = [];
        $data = $this->objConfig->getObjClassSelectAjax($this->request->input('field'));
        $result = $data['model']->orWhere($data['select'], 'like', '%' . $this->request->input('term') . '%')->limit(10)->select($data['id'], $data['select'])->get()->toArray();
        foreach ($result as $item) {
            $new_data[] =['id' => [$item[$data['id']]], 'text' =>$item[$data['select']]];
        }
        // 'pagination' => ['more' => true]]
        return json_encode(['results' => $new_data]);

    }

}