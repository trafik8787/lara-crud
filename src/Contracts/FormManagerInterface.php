<?php
/**
 * Created by PhpStorm.
 * User: Vitalik
 * Date: 18.09.2017
 * Time: 13:09
 */

namespace Trafik8787\LaraCrud\Contracts;


interface FormManagerInterface
{
    /**
     * @param $typeSql тип данных
     * @param $nameField
     * @return mixed
     */
    public function getDataType ($typeSql, $nameField);
    public function getNameColumns ():array ;
    public function getTypeColumns ():array ;
    public function getArrayField ();

}