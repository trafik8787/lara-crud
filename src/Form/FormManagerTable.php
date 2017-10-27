<?php
namespace Trafik8787\LaraCrud\Form;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Collection;
use Trafik8787\LaraCrud\Contracts\Component\ComponentManagerBuilderInterface;
use Trafik8787\LaraCrud\Contracts\Component\TabsInterface;
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
            'varchar' => 'text',
            'tinyint' => 'number',
            'simple_array' => 'text',

           );


        return $arrFieldTypeInput[$typeSql];
    }




    /**
     * @param string $field
     * @return bool
     * todo определяет является ли поле multiple
     */
    public function getMultiple(string $field):bool
    {
        if (!empty($this->objConfig->getFileUploadSeting($field))) {
            $arr_file = $this->objConfig->getFileUploadSeting($field);
            if ($arr_file['status'] === 'multiple') {
                return true;
            }
        }

        if (!empty($this->objConfig->getTypeFieldAllArr($field))) {
            $tmp = $this->objConfig->getTypeFieldAllArr($field);
            if (!empty($tmp[2]) and $tmp[2] === 'multiple') {
                return true;
            }
        }

        return false;
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
     * todo подготовка масива полей для передачи в клас строителя
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
                'enableEditor' => $this->objConfig->getEnableEditor($name),
                'title' => $this->objConfig->getFieldTitle($name),
                'placeholder' => $this->objConfig->getFieldPlaceholder($name),
                'sqlType' => $typeColumn[$name],
                'type' => $this->getDataType($typeColumn[$name], $name), //тип поля для input
                'typeField' => $this->objConfig->getTypeField($name), //виды полей select input textarea
                'multiple' => $this->getMultiple($name),
                'options' => $this->objConfig->getFieldOption($name)
            ];
        }

        return collect($data);
    }

}