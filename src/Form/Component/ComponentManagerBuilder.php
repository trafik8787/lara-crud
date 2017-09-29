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

    public $objField;
    private $typeField;
    public $type; //тип поля input
    public $classStyle;
    public $placeholder;
    public $value;
    public $label;
    public $name;
    public $title;


    public function __construct ($arrField) {
       // dd($arrField);

        $this->objField = $arrField;
    }

    /**
     * @param string $data
     * @return $this
     */
    public function classStyle()
    {
        $this->classStyle = $this->objField['classStyle'];
        return $this;
    }


    /**
     * @param string $data
     * @return $this
     */
    public function placeholder()
    {
        $this->placeholder = $this->objField['placeholder'];
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
    public function type ()
    {
        $this->type = $this->objField['type'];
        return $this;
    }

    /**
     *
     * @return $this
     */
    public function label ()
    {
        $this->label = $this->objField['label'];
        return $this;
    }

    /**
     * @param string $data
     * @return $this
     */
    public function name()
    {
        $this->name = $this->objField['field'];
        return $this;
    }

    /**
     * @param string $data
     * @return $this
     */
    public function title()
    {
        $this->title = $this->objField['title'];
        return $this;
    }

    /**
     * @return Select|Text
     */
    public function build()
    {
        switch ($this->objField['typeField']) {
            case 'input':
                return new Text($this);

            case 'select':
                return new Select($this);
        }

    }
}