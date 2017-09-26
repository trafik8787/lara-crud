<?php
/**
 * Created by PhpStorm.
 * User: Vitalik
 * Date: 22.09.2017
 * Time: 12:46
 */
namespace Trafik8787\LaraCrud\Form\Component;

use Trafik8787\LaraCrud\Contracts\Component\ComponentManagerBuilderInterface;

class Text
{
    public $type; //тип поля input
    public $classStyle;
    public $placeholder;
    public $value;
    public $name;
    public $title;

    public $view = 'lara::Form.Component.text';

    public function __construct(ComponentManagerBuilderInterface $managerBuilder)
    {
        $this->type = $managerBuilder->type;
        $this->classStyle = $managerBuilder->classStyle;
        $this->placeholder = $managerBuilder->placeholder;
        $this->value = $managerBuilder->value;
        $this->name = $managerBuilder->name;
        $this->title = $managerBuilder->title;
    }


    public function run ()
    {
        return view($this->view, ['obj' => $this])->render();
    }

}