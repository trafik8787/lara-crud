<?php
/**
 * Created by PhpStorm.
 * User: Vitalik
 * Date: 22.09.2017
 * Time: 12:46
 */

namespace Trafik8787\LaraCrud\Form\Component;

use Trafik8787\LaraCrud\Contracts\Component\ComponentManagerBuilderInterface;

class Textarea
{
    public $classStyle;
    public $placeholder;
    public $value;
    public $name;
    public $title;
    public $enableEditor;
    public $tooltip;
    public $required;
    public $attribute;

    public $view = 'lara::Form.Component.textarea';

    /**
     * Text constructor.
     * @param ComponentManagerBuilderInterface $managerBuilder
     */
    public function __construct(ComponentManagerBuilderInterface $managerBuilder)
    {
        $this->classStyle = $managerBuilder->classStyle;
        $this->placeholder = $managerBuilder->placeholder;
        $this->value = $managerBuilder->value;
        $this->label = $managerBuilder->label;
        $this->name = $managerBuilder->name;
        $this->title = $managerBuilder->title;
        $this->enableEditor = $managerBuilder->enableEditor;
        $this->tooltip = $managerBuilder->tooltip;
        $this->required = $managerBuilder->required;
        $this->attribute = $managerBuilder->attribute;
    }


    /**
     * @return string
     */
    public function run()
    {
        return view($this->view, ['obj' => $this])->render();
    }

}