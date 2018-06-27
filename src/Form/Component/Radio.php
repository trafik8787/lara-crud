<?php
/**
 * Created by PhpStorm.
 * User: Vitalik
 * Date: 27.09.2017
 * Time: 22:45
 */

namespace Trafik8787\LaraCrud\Form\Component;

use Trafik8787\LaraCrud\Contracts\Component\ComponentManagerBuilderInterface;

class Radio
{
    public $value;
    public $name;
    public $title;
    public $label;
    public $classStyle;
    public $tooltip;
    public $attribute;

    public $view = 'lara::Form.Component.radio';

    public function __construct(ComponentManagerBuilderInterface $managerBuilder)
    {
        $this->classStyle = $managerBuilder->classStyle;
        $this->value = $managerBuilder->value;
        $this->label = $managerBuilder->label;
        $this->name = $managerBuilder->name;
        $this->title = $managerBuilder->title;
        $this->tooltip = $managerBuilder->tooltip;
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