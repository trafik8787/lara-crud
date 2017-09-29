<?php
/**
 * Created by PhpStorm.
 * User: Vitalik
 * Date: 21.09.2017
 * Time: 10:46
 */

namespace Trafik8787\LaraCrud\Contracts;


interface NodeInterface
{
    /**
     * @return mixed
     */
    public function showDisplay();

    /**
     * @return mixed
     */
    public function showEditDisplay();

    /**
     * @return mixed
     */
    public function showInsertDisplay();

    /**
     * @return mixed
     */
    public function showDelete();

}