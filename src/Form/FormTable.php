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


class FormTable extends FormManagerTable
{



    public function renderForm() {
        $this->id = $this->admin->route->parameters['adminModelId'];

        $data = [
          'id' => $this->id,
          'urlAction' => $this->admin->route->parameters['adminModel'],
            'objField' => $this->getFieldRender()
        ];

        dump($this->objConfig->nameColumns());
        dump($this->admin->TableTypeColumns);
//        dump($this->objConfig);
        dump($this->getFieldRender());
        $this->getModelData();
        return view('lara::Form.form', $data);
    }


    public function getModelData () {

        $result = $this->objConfig->getModelObj()->find($this->id);
       // dump($result->lastname);
    }

    /**
     * todo должен возвращать масив с отрендеренными tamplate component
     */
    public function getFieldRender ()
    {

    }

}