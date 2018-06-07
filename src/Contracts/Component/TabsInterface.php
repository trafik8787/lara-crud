<?php
/**
 * Created by PhpStorm.
 * User: Vitalik
 * Date: 09.10.2017
 * Time: 18:46
 */

namespace Trafik8787\LaraCrud\Contracts\Component;


interface TabsInterface
{
    /**
     * @param $obj
     * @return mixed
     */
    public function objConfig($obj);

    /**
     * @return mixed
     * todo название вкладки
     */
    public function name();

    /**
     * @return mixed
     * todo рендер вкладок
     */
    public function build($result);

    /**
     * @return mixed
     */
    public function TabFore1($result, $nameTab, $itam);

}