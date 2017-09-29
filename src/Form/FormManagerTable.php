<?php
namespace Trafik8787\LaraCrud\Form;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Collection;
use Trafik8787\LaraCrud\Contracts\Component\ComponentManagerBuilderInterface;
use Trafik8787\LaraCrud\Contracts\FormManagerInterface;


/**
 * Created by PhpStorm.
 * User: Vitalik
 * Date: 18.09.2017
 * Time: 13:07
 */

abstract class FormManagerTable implements FormManagerInterface
{
    public $objConfig;
    public $admin;
    protected $componentManager;
    protected $id;
    protected $fieldBulder;


    /**
     * FormManagerTable constructor.
     * @param Application $app
     */
    public function __construct (Application $app) {


    }


    /**
     * @param $field
     * @return mixed
     * todo получить поля в зависимоти от типов данных
     */
    public function getDataType ($typeSql, $nameField)
    {

        if (!empty($this->objConfig->getTypeField($nameField))) {
            return $this->objConfig->getTypeField($nameField);
        }

        $arrFieldTypeInput = array(
            'string' => 'text',
            'datetime' => 'datetime',
            'date' => 'date',
            'integer' => 'number',
            'bool'=> 'checkbox',
            'boolean' => 'checkbox',
            'float' => 'number',
            'text'  => 'text',
            'time'  => 'datetime',
            'blob' => 'text',
            'bigint' => 'number',
            'decimal' => 'text',

           );


        return $arrFieldTypeInput[$typeSql];
    }



    /**
     * @return array
     * //получаем масив полей и их нахваний без индексного поля
     */
    public function getNameColumns ():array
    {
        //dd($this->objConfig->nameColumns());
        return array_diff_key($this->objConfig->nameColumns(), array($this->admin->KeyName => $this->admin->KeyName));
    }

    /**
     * @return array
     * //получаем масив полей и их типов
     */
    public function getTypeColumns():array
    {
        return array_diff_key($this->admin->TableTypeColumns, array($this->admin->KeyName => $this->admin->KeyName));
    }

    /**
     * @return array
     */
    public function getArrayField ()
    {
        $data = [];
        $typeColumn = $this->getTypeColumns();

        foreach ($this->getNameColumns() as $name => $nameColumn) {

            $data[] = [
                'field' => $name,
                'label' => $nameColumn,
                'classStyle' => $this->objConfig->getFieldClass($name),
                'disableEditor' => $this->objConfig->getDisableEditor($name),
                'title' => $this->objConfig->getFieldTitle($name),
                'placeholder' => $this->objConfig->getFieldPlaceholder($name),
                'sqlType' => $typeColumn[$name],
                'type' => $this->getDataType($typeColumn[$name], $name), //тип поля для input
                'typeField' => $this->objConfig->getTypeField($name) //виды полей select input textarea
            ];
        }

        return collect($data);
    }

}