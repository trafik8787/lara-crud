<?php
/**
 * Created by PhpStorm.
 * User: vitalik
 * Date: 06.06.18
 * Time: 9:47
 */

namespace Trafik8787\LaraCrud\Contracts;


interface ActionTableInterface
{
    /**
     * @param $objConfig
     * @return mixed
     */
    public function objConfig ($objConfig);

    /**
     * @param int $id
     * @return mixed
     */
    public function render(int $id);

    /**
     * @return bool
     */
    public function enableColumnAction():bool;

}