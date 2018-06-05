<?php
/**
 * Created by PhpStorm.
 * User: vitalik
 * Date: 31.05.18
 * Time: 14:17
 */

namespace Trafik8787\LaraCrud\Contracts;


interface ChildRowsInterface
{
    public function view ($view = null);
    public function model ($model = null);
    public function render($objConfig);
}