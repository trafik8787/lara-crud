<?php
/**
 * Created by PhpStorm.
 * User: Vitalik
 * Date: 12.01.2018
 * Time: 17:46
 */

namespace Trafik8787\LaraCrud\Console\Commands;



class InstallExample extends Command
{

    protected $name = 'lara:example';

    protected $description = 'Installation Class';


    protected $class_install = [
        CreateProviderExample::class,
        CreateMigrationExample::class
    ];

    protected function Installalation() {

        collect($this->class_install)->map(function ($class){
            return new $class($this);
        })->each(function ($class){
            $class->showInfo();
            $class->install();
        });

    }

}