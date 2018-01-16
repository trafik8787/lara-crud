<?php

namespace Trafik8787\LaraCrud\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputArgument;

/**
 * Class ModelGenerate
 * @package Trafik8787\LaraCrud\Console\Commands
 */
class ModelGenerate extends GeneratorCommand
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lara:model {name} {--tableExample=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate model';


    /**
     * @return string
     */
    public function getStub ()
    {
        return __DIR__.'/stubs/model.stub';
    }

    /**
     * @param string $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return 'App\Http\Node\Model';
    }

    /**
     * @param string $stub
     * @param string $name
     * @return mixed
     */
    protected function replaceClass($stub, $name)
    {
        $stub = parent::replaceClass($stub, $name);

        $table = null;
        if (!empty($this->option('tableExample'))) {
            $table = 'protected $table = \''.$this->option('tableExample').'\';';
        }

        return str_replace(['ModelStud', 'TableStud'], [trim($this->argument('name')), $table], $stub);
    }

    /**
     * @return array
     */
    protected function getArguments()
    {
        $arguments = parent::getArguments();
        $arguments[] = ['name', InputArgument::REQUIRED, 'The name of the model class'];

        return $arguments;
    }

}
