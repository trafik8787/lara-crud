<?php
/**
 * Created by PhpStorm.
 * User: Vitalik
 * Date: 18.09.2017
 * Time: 13:25
 */

namespace Trafik8787\LaraCrud\Form;

use Illuminate\Contracts\Foundation\Application;
use Trafik8787\LaraCrud\Contracts\Component\ComponentManagerInterface;
use Trafik8787\LaraCrud\Contracts\FormManagerInterface;
use Trafik8787\LaraCrud\Form\Component\ComponentManagerBuilder;


class FormTable extends FormManagerTable
{


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
        $model = $this->getModelData();
       // dd($model);
        $result = [];

        foreach ($this->getArrayField() as $item) {

            $objBilder = (new ComponentManagerBuilder($item));
                $objBilder->classStyle();
                $objBilder->type();
                $objBilder->label();
                $objBilder->placeholder();
                $objBilder->title();

                if ($model !== null) {
                    $objBilder->value($model->{$item['field']});
                }

            $result[] = $objBilder->build()->run();
        }
        return $result;
    }


    /**
     * @return \Illuminate\Http\RedirectResponse
     * todo форма обновления
     */
    public function updateForm ()
    {
        $arr_request = $this->admin->getRequest()->all();

        unset($arr_request['_method']);
        unset($arr_request['_token']);

        $nameColumn = $this->objConfig->nameColumns();
        $model = $this->objConfig->getModelObj()->find($arr_request[$this->admin->KeyName]);

        foreach ($arr_request as $name => $item) {
            if (!empty($nameColumn[$name])) {
                $model->{$name} = $item;
            }
        }

        $model->save();

        if (!empty($arr_request['save_button'])) {
            return redirect('/' . config('lara-config.url_group') . '/' . $this->admin->route->parameters['adminModel']);
        }

        return redirect()->back();
    }


    /**
     * @return \Illuminate\Http\RedirectResponse
     * todo форма добавления
     */
    public function insertForm ()
    {
        $arr_request = $this->admin->getRequest()->all();

        unset($arr_request['_token']);

        $nameColumn = $this->objConfig->nameColumns();

        $model = $this->objConfig->getModelObj();

        foreach ($arr_request as $name => $item) {
            if (!empty($nameColumn[$name])) {
                $model->{$name} = $item;
            }
        }
        $model->save();

        if (!empty($arr_request['save_button'])) {
            return redirect('/' . config('lara-config.url_group') . '/' . $this->admin->route->parameters['adminModel']);
        }

        return redirect()->back();
    }

}