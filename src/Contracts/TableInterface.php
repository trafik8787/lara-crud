<?php
/**
 * Created by PhpStorm.
 * User: Vitalik
 * Date: 12.08.2017
 * Time: 17:20
 */

namespace Trafik8787\LaraCrud\Contracts;


use Trafik8787\LaraCrud\Models\NodeModelConfigurationManager;

interface TableInterface
{

    /**
     * @param $admin
     * @return mixed
     */
    public function render();

    /**
     * @return mixed
     */
    public function renderDashboard();

    /**
     * @return mixed
     */
    public function getColumn();

    /**
     * @param $admin
     * @return mixed
     */
    public function jsonResponseTable($admin);

    /**
     * @param $admin
     * @return mixed
     */
    public function getModelData($total, $curent_page, $searchValue, $order);

    /**
     * @param $admin
     * @return mixed
     */
    public function deleteRows($admin);


    /**
     * @return array
     * todo order[0][column]: получаем название поля по индексу переданному из DataTable
     */
    public function nameColumnsOrder(int $index): string;


    /**
     * @param $arr_id
     * @return mixed
     */
    public function groupDelete($request);

    /**
     * @param $request
     * @return mixed
     */
    public function copyData($request);


    /**
     * @param $objModel
     * @param $searchValue
     * @param $TableColumns
     * @return mixed
     */
    public function searchModel($objModel, $searchValue, $TableColumns);

    /**
     * @return mixed
     */
    public function customRender();

}