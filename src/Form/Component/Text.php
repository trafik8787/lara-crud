<?php
/**
 * Created by PhpStorm.
 * User: Vitalik
 * Date: 22.09.2017
 * Time: 12:46
 */
namespace Trafik8787\LaraCrud\Form\Component;

use Trafik8787\LaraCrud\Form\FormManagerTable;

class Text extends ComponentManager
{

    protected $view = 'Form.Component.text';

    public function run ()
    {
        return view($this->view, ['obj' => $this]);
    }

}