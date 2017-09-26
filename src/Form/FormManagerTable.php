<?php
namespace Trafik8787\LaraCrud\Form;
use Illuminate\Contracts\Foundation\Application;
use Trafik8787\LaraCrud\Contracts\Component\ComponentManagerInterface;
use Trafik8787\LaraCrud\Contracts\FormManagerInterface;
use Trafik8787\LaraCrud\Form\Component\Text;

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

    public function __construct (Application $app, ComponentManagerInterface $componentManager) {
        $this->componentManager = $componentManager;
    }


    public function getFieldType ($field)
    {
        $arrField = array(
            'varchar' => 'text',
            'text' => array('tag' => 'textarea'),
            'date' => 'date',
            'int' => 'number',
            'bigint' => 'number',
            'tinyint' => 'number',
            'smallint' => 'number',
            'mediumint' => 'number',
            'float' => 'number',
            'double' => 'number',
            'bool'=> 'checkbox',
            'boolean' => 'checkbox',
            'bit' => 'checkbox',
            'char' =>  array('tag' => 'textarea'),
            'tinytext' => 'text',
            'mediumtext' => array('tag' => 'textarea'),
            'longtext' => array('tag' => 'textarea'),
            'tinyblob' => 'text',
            'blob' => 'text',
            'mediumblob' => array('tag' => 'textarea'),
            'longblob' => array('tag' => 'textarea'),
            'datetime' => 'datetime',
            'time' => 'time',
            'year' => 'month',
            'timestamp' => 'datetime');

        return $arrField[$field];
    }


    public function renderForm()
    {
        // TODO: Implement renderForm() method.
    }
}