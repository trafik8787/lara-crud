<?php

namespace Trafik8787\LaraCrud\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputArgument;

class ModelGenerate extends GeneratorCommand
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lara:model {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';


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


        return str_replace('ModelStud', trim($this->argument('name')), $stub);
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
