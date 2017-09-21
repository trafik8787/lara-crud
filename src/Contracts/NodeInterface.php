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
    public function showDisplay();
    public function showEditDisplay();
    public function showInsertDisplay();
    public function showDelete();

}