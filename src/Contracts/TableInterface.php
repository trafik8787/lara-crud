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

    public function render();
    public function getColumn();
    public function jsonResponseTable();
}