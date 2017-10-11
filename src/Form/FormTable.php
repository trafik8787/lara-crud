<?php
/**
 * Created by PhpStorm.
 * User: Vitalik
 * Date: 18.09.2017
 * Time: 13:25
 */

namespace Trafik8787\LaraCrud\Form;

use Illuminate\Contracts\Foundation\Application;
use Trafik8787\LaraCrud\Contracts\Component\TabsInterface;
use Trafik8787\LaraCrud\Contracts\Component\UploadFileInterface;
use Trafik8787\LaraCrud\Form\Component\ComponentManagerBuilder;
use Trafik8787\LaraCrud\Form\Component\File;


class FormTable extends FormManagerTable
{

    private $tabs;
    private $file;

    public function __construct (TabsInterface $tabs, UploadFileInterface $file) {
        $this->tabs = $tabs;
        $this->file = $file;
    }
    /**
     * @param string $form = edit|insert
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function renderFormEdit () {



        $this->id = $this->admin->route->parameters['adminModelId'];

        $data = [
          'id' => $this->id,
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
       // dd($model);
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
                $objBilder->disableEditor();


                if (!empty($model->{$item['field']})) {
                    $model_field_value = $model->{$item['field']};
                }

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

        $this->FormRequestModelSave('update');

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

        $this->FormRequestModelSave('insert');

        if (!empty($arr_request['save_button'])) {
            return redirect('/' . config('lara-config.url_group') . '/' . $this->admin->route->parameters['adminModel']);
        }

        return redirect()->back();
    }


    public function FormRequestModelSave($type)
    {
        $model = [];
        //конфиг добавляем в класс
        $arr_request = $this->file->objConfig($this->objConfig);

        $nameColumn = $this->objConfig->nameColumns();
        if ($type === 'update') {

            $model = $this->objConfig->getModelObj()->find($arr_request[$this->admin->KeyName]);

            unset($arr_request['_method']);
            unset($arr_request['_token']);

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
    }
}