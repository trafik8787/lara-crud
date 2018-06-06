<?php
/**
 * Created by PhpStorm.
 * User: Vitalik
 * Date: 22.09.2017
 * Time: 12:46
 */

namespace Trafik8787\LaraCrud\Form\Component;

use Trafik8787\LaraCrud\Contracts\Component\ComponentManagerBuilderInterface;
use Trafik8787\LaraCrud\Traits\Helper;

class Text
{
    use Helper;

    public $type; //тип поля input
    public $classStyle;
    public $placeholder;
    public $value;
    public $name;
    public $title;
    public $label;
    public $tooltip;
    public $multiple;
    public $one_to_many;
    public $required;


    public $view = 'lara::Form.Component.text';
    public $view_date = 'lara::Form.Component.text_date';
    public $view_multiple = 'lara::Form.Component.text_multiple';


    /**
     * Text constructor.
     * @param ComponentManagerBuilderInterface $managerBuilder
     */
    public function __construct(ComponentManagerBuilderInterface $managerBuilder)
    {
        $this->type = $managerBuilder->type;
        $this->classStyle = $managerBuilder->classStyle;
        $this->placeholder = $managerBuilder->placeholder;
        $this->value = $managerBuilder->value;
        $this->label = $managerBuilder->label;
        $this->name = $managerBuilder->name;
        $this->title = $managerBuilder->title;
        $this->tooltip = $managerBuilder->tooltip;
        $this->multiple = $managerBuilder->multiple;
        $this->one_to_many = $managerBuilder->one_to_many;
        $this->required = $managerBuilder->required;


//        switch ($this->type) {
//            case 'date':
//                $this->view = $this->view_date;
//
//        }

        if ($this->one_to_many) {
            $this->view = $this->view_multiple;
        }

    }


    /**
     * @return string
     */
    public function run()
    {
        return view($this->view, ['obj' => $this])->render();
    }


}