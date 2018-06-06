<?php
/**
 * Created by PhpStorm.
 * User: Vitalik
 * Date: 12.01.2018
 * Time: 17:46
 */

namespace Trafik8787\LaraCrud\Console\Commands;


/**
 * Class InstallCommand
 * @package Trafik8787\LaraCrud\Console\Commands
 */
class InstallCommand extends Command
{
    protected $name = 'lara:install';
    protected $description = 'Installation Class';
    protected $class_install = [
        CreateProvider::class
    ];

    protected function Installalation()
    {
        collect($this->class_install)->map(function ($class) {
            return new $class($this);

        })->filter(function ($class) {
            return !$class->installed();
        })->each(function ($class) {
            $class->showInfo();
            $class->install();
        });
    }
}