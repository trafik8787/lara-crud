<?php
/**
 * Created by PhpStorm.
 * User: Vitalik
 * Date: 13.01.2018
 * Time: 19:42
 */

namespace Trafik8787\LaraCrud\Contracts\Console;

interface InstallerInterface
{

    /**
     * @return mixed
     */
    public function showInfo();


    /**
     * @return mixed
     */
    public function install();


    /**
     * @return mixed
     */
    public function installed();
}