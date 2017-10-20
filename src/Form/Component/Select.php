<?php
/**
 * Created by PhpStorm.
 * User: Vitalik
 * Date: 27.09.2017
 * Time: 22:42
 */

namespace Trafik8787\LaraCrud\Form\Component;

use Trafik8787\LaraCrud\Contracts\Component\ComponentManagerBuilderInterface;

class Select
{
    public $classStyle;
    public $placeholder;
    public $value;
    public $name;
    public $title;
    public $multiple;
    public $options;


    public $view = 'lara::Form.Component.select';
    /**
     * Select constructor.
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
        $this->multiple =  $managerBuilder->multiple;
        $this->options =  $managerBuilder->options;
    }

    /**
     * @return mixed
     */
    public function run ()
    {
        return view($this->view, ['obj' => $this])->render();
    }
}