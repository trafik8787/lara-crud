<?php
/**
 * Created by PhpStorm.
 * User: vitalik
 * Date: 31.01.19
 * Time: 11:45
 */

namespace Trafik8787\LaraCrud\Contracts\Model;


interface JoinTablesInterface
{

    /**
     * @return mixed
     */
    public function select ($fieldTable, $asName);

}