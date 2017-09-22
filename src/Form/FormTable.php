<?php
/**
 * Created by PhpStorm.
 * User: Vitalik
 * Date: 18.09.2017
 * Time: 13:25
 */

namespace Trafik8787\LaraCrud\Form;

use Illuminate\Contracts\Foundation\Application;
use Trafik8787\LaraCrud\Contracts\FormManagerInterface;


class FormTable extends FormManagerTable
{



    public function formRenderEdit() {
        dump($this->componentManager);
        dump($this->admin);
        dump($this->objConfig);
        return view('lara::Form.form');
    }

    public function getModelData () {

    }

}