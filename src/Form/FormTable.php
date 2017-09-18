<?php
/**
 * Created by PhpStorm.
 * User: Vitalik
 * Date: 18.09.2017
 * Time: 13:25
 */

namespace Trafik8787\LaraCrud\Form;


use Illuminate\Contracts\Foundation\Application;
use Trafik8787\LaraCrud\Contracts\AdminInterface;
use Trafik8787\LaraCrud\Contracts\FormManagerInterface;

class FormTable extends FormManagerTable
{



    public function __construct (Application $app) {

    }

    public function injectObjConfig ($objConfig)
    {
        $this->objConfig = $objConfig;
    }





    public function formRender() {
        return view('lara::Form.form');
    }

}