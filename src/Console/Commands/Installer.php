<?php
/**
 * Created by PhpStorm.
 * User: Vitalik
 * Date: 13.01.2018
 * Time: 19:44
 */

namespace Trafik8787\LaraCrud\Console\Commands;

use Trafik8787\LaraCrud\Contracts\Console\InstallerInterface;

/**
 * Class Installer
 * @package Trafik8787\LaraCrud\Console\Commands
 */
abstract class Installer implements InstallerInterface
{
    protected $command;

    public function __construct($command)
    {
        $this->command = $command;
    }

    public function installed()
    {
        return false;
    }
}