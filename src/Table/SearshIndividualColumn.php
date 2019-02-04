<?php
/**
 * Created by PhpStorm.
 * User: vitalik
 * Date: 02.02.19
 * Time: 19:50
 */

namespace Trafik8787\LaraCrud\Table;


use Exception;
use Trafik8787\LaraCrud\Contracts\SearshIndividualColumnInterface;
use Trafik8787\LaraCrud\Models\NodeModelConfigurationManager;

/**
 * Class SearshIndividualColumn
 * @package Trafik8787\LaraCrud\Table
 */
class SearshIndividualColumn implements SearshIndividualColumnInterface
{

    public $objConfig;
    protected $arrColumn; //масив полей передданних в конструктор
    protected $changeColumn = [];
    protected $tmpColumn;

    public $view = 'lara::Table.search_column';

    public function __construct($arrColumn = null, NodeModelConfigurationManager $objConfig)
    {
        $this->arrColumn = $arrColumn;
        $this->objConfig = $objConfig;
    }

    /**
     * @return mixed|string
     * @throws \Throwable
     */
    public function render()
    {
        return view($this->view, ['columns' => $this->getColumns(),
            'name_field' => $this->objConfig->nameColumns()])->render();
    }

    /**
     * @param $column
     * @return $this|mixed
     */
    public function column($column)
    {
        $this->tmpColumn = null;
        $this->tmpColumn = $column;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getColumns()
    {

        return array_merge(
            (!empty($this->arrColumn)) ? array_flip($this->arrColumn) : [],
            $this->changeColumn);
    }

    /**
     * @param $valueArr
     * @return $this
     * @throws Exception
     */
    public function selectControl($valueArr)
    {
        if (!empty($this->tmpColumn)) {
            $this->changeColumn[$this->tmpColumn] = $valueArr;
            $this->tmpColumn = null;
            return $this;
        }

        throw new Exception('Extraordinary challenge selectControl()');

    }

    /**
     * @param $columns
     * @return array
     */
    public function searchColumn ($columns)
    {
        $searchColumn = [];

        if (!empty($columns)) {

            foreach ($columns as $column) {

                if ($column['search']['value'] != '') {
                    //получаем названия полей по полю после AS
                    $col = $this->objConfig->joinTableObj()->getFieldToAs($column['data']);
                    $searchColumn[$col] = $column['search']['value'];
                }
            }
        }

        return $searchColumn;
    }
}