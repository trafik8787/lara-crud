<?php
/**
 * Created by PhpStorm.
 * User: Vitalik
 * Date: 22.09.2017
 * Time: 12:46
 */
namespace Trafik8787\LaraCrud\Form\Component;

use Illuminate\Http\Request;
use Trafik8787\LaraCrud\Contracts\Component\ComponentManagerBuilderInterface;
use Trafik8787\LaraCrud\Traits\Helper;

class File
{

    use Helper;

    public $classStyle;
    public $placeholder;
    public $value;
    public $name;
    public $title;
    public $multiple;
    public $label;
    public $tooltip;
    public $required;

    public $view = 'lara::Form.Component.file';

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
        $this->multiple =  $managerBuilder->multiple;
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