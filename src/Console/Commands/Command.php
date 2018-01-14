<?php
/**
 * Created by PhpStorm.
 * User: Vitalik
 * Date: 13.01.2018
 * Time: 16:10
 */

namespace Trafik8787\LaraCrud\Console\Commands;
use Illuminate\Console\Command as ConsoleCommand;
use Illuminate\Console\ConfirmableTrait;
use Illuminate\Filesystem\Filesystem;

abstract class Command extends ConsoleCommand
{
    use ConfirmableTrait;

    protected $files;


    public function handle(Filesystem $files) {


        if (! defined('SLEEPINGOWL_STUB_PATH')) {
            define('SLEEPINGOWL_STUB_PATH', __DIR__.'/stubs');
        }

        if (! $this->confirmToProceed('Lara-Crud Admin')) {
            return;
        }

        $this->call('vendor:publish', ['--tag' => 'config']);

        $this->files = $files;

        $this->Installalation();
    }

    abstract protected function Installalation();

    public function files()
    {
        return $this->files;
    }
}