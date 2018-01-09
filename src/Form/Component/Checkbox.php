<?php
/**
 * Created by PhpStorm.
 * User: Vitalik
 * Date: 27.09.2017
 * Time: 22:44
 */

namespace Trafik8787\LaraCrud\Form\Component;
use Trafik8787\LaraCrud\Contracts\Component\ComponentManagerBuilderInterface;

/**
 * Class Checkbox
 * @package Trafik8787\LaraCrud\Form\Component
 */
class Checkbox
{

    public $value;
    public $name;
    public $title;
    public $label;
    public $classStyle;
    public $tooltip;
    public $required;

    public $view = 'lara::Form.Component.checkbox';

    /**
     * Checkbox constructor.
     * @param ComponentManagerBuilderInterface $managerBuilder
     */
    public function __construct (ComponentManagerBuilderInterface $managerBuilder) {

        $this->classStyle = $managerBuilder->classStyle;
        $this->value = $managerBuilder->value;
        $this->label = $managerBuilder->label;
        $this->name = $managerBuilder->name;
        $this->title = $managerBuilder->title;
        $this->tooltip = $managerBuilder->tooltip;
        $this->required = $managerBuilder->required;
    }

    /**
     * @return string
     */
    public function run ()
    {
        return view($this->view, ['obj' => $this])->render();
    }
}