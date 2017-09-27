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
    public function renderForm(string $form) {
        $this->id = $this->admin->route->parameters['adminModelId'];

        if($form === 'edit'){
            $metod = 'PATCH';
        } elseif ($form === 'insert') {
            $metod = 'POST';
        }

        $data = [
          'id' => $this->id,
          'urlAction' => $this->admin->route->parameters['adminModel'],
          'titlePage'  => $this->objConfig->getTitle(),
          'formMetod' => $metod,
          'objField' => $this->getFieldRender()
        ];



//        dump($this->admin);
////        dump($this->objConfig);
//        dump($this->getFieldRender());
//
//        dump($this->getNameColumns());
        //dump($this->getTypeColumns());

//        dump($this->getArrayField());

        return view('lara::Form.form', $data);
    }


    /**
     * @return mixed
     */
    public function getModelData () {
        return $this->objConfig->getModelObj()->find($this->id);
    }

    /**
     * todo должен возвращать масив с отрендеренными tamplate component
     */
    public function getFieldRender ()
    {
        $model = $this->getModelData();
        //dd($model->id);
        $result = [];
        foreach ($this->getArrayField() as $nameField => $item) {

            $result[] = (new ComponentManagerBuilder($nameField, $item))
                ->classStyle()
                ->type()
                ->label()
                ->value($model->{$nameField})
                ->build()->run();
        }
        return $result;
    }

    /**
     *
     */
    public function updateForm ()
    {
        dump($this->admin->getRequest());



    }

}