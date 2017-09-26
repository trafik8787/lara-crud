<?php
/**
 * Created by PhpStorm.
 * User: Vitalik
 * Date: 22.09.2017
 * Time: 13:27
 */

namespace Trafik8787\LaraCrud\Form\Component;


use Trafik8787\LaraCrud\Contracts\Component\ComponentManagerBuilderInterface;


/**
 * Class ComponentManagerBuilder
 * @package Trafik8787\LaraCrud\Form\Component
 * patern Builder
 */
class ComponentManagerBuilder implements ComponentManagerBuilderInterface
{

    public $type; //тип поля input
    public $classStyle;
    public $placeholder;
    public $value;
    public $name;
    public $title;


    public function __construct (string $typeField) {

        $this->type = $typeField;
    }

    /**
     * @param string $data
     * @return $this
     */
    public function classStyle(string $data = 'form-control')
    {
        $this->classStyle = $data;
        return $this;
    }


    /**
     * @param string $data
     * @return $this
     */
    public function placeholder(string $data = 'Введите значение')
    {
        $this->placeholder = $data;
        return $this;
    }


    /**
     * @param string $data
     * @return $this
     */
    public function value($data = '')
    {
        $this->value = $data;
        return $this;
    }


    /**
     * @param string $data
     * @return $this
     */
    public function name(string $data= '')
    {
        $this->name = $data;
        return $this;
    }

    /**
     * @param string $data
     * @return $this
     */
    public function title(string $data)
    {
        $this->title = $data;
        return $this;
    }

    public function build(): Text
    {
        return new Text($this);
    }
}