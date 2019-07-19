<?php
/**
 * Created by PhpStorm.
 * User: vitalik
 * Date: 31.01.19
 * Time: 11:32
 */

namespace Trafik8787\LaraCrud\Models;

use Trafik8787\LaraCrud\Contracts\Model\JoinTablesInterface;

/**
 * Class JoinTables
 * @package Trafik8787\LaraCrud\Models
 */
class JoinTables implements JoinTablesInterface
{

    protected $select;
    protected $joinTable = null;
    protected $asName = null;
    protected $fieldToAs;
    protected $typeJoin = 'join'; //тип джойна Left, Right, Inner

    /**
     * @param $tableName
     * @param $tableColumnNew
     * @param $tableColumnOld
     * @return $this
     */
    public function joinTable($tableName = null, $tableColumnNew = null, $tableColumnOld = null, $closure = null)
    {
        $this->joinTable[$tableName] = [$tableColumnNew, $tableColumnOld, $closure];

        return $this;
    }

    /**
     * @return $this|mixed
     */
    public function select($fieldTable, $asName)
    {
        $this->asName[] = $asName;
        $this->select[$fieldTable] = $asName;
        $this->fieldToAs[$asName] = $fieldTable;

        return $this;
    }

    /**
     * @return mixed
     *
     */
    public function getSelect()
    {
        $data = [];
        if (!empty($this->select)) {
            foreach ($this->select as $field => $item) {
                $data[] = $field . ' as ' . $item;
            }
        }

        return $data;
    }

    /**
     * @return array
     */
    public function getAsNameSearch()
    {
        return array_keys($this->select);
    }

    /**
     * @param $fieldAs
     * @return mixed
     */
    public function getFieldToAs($fieldAs)
    {
        return $this->fieldToAs[$fieldAs];
    }

    /**
     * @param $field
     * @return mixed
     */
    public function getField($field)
    {
        $arr = array_flip($this->select);
        return $arr[$field];
    }

    /**
     * @return |null
     */
    public function getAsName()
    {
        return $this->asName;
    }

    /**
     * @return mixed
     */
    public function getJoinTable()
    {
        return $this->joinTable;
    }

    /**
     * @return $this
     */
    public function leftJoin()
    {
        $this->typeJoin = 'leftJoin';
        return $this;
    }

    /**
     * @return $this
     */
    public function rightJoin()
    {
        $this->typeJoin = 'rightJoin';
        return $this;
    }
    /**
     * @param $model
     * @return mixed
     * приджойниваем таблицы к модели
     */
    public function setModel ($model)
    {
        if ($this->joinTable !== null) {
            foreach ($this->joinTable as $table => $item) {
                //проверка есть ли колбек
                if ($item[2] !== null) {
                    $model = $item[2]->call($this, $model);
                } else {
                    $model = $model->{$this->typeJoin}($table, $item[0], '=', $item[1]);
                }
            }
        }

        return $model;
    }

}