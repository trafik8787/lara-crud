<?php

namespace Trafik8787\LaraCrud\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputArgument;

/**
 * Class NodeGenerate
 * @package Trafik8787\LaraCrud\Console\Commands
 */
class NodeGenerate extends GeneratorCommand
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lara:node {name} {--tableExample=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a class and model';


    /**
     * @return string
     */
    public function getStub()
    {
        if (!empty($this->option('tableExample'))) {
            return $this->getExampleStub();
        }
        return __DIR__ . '/stubs/node.stub';
    }

    /**
     * @return string
     */
    public function getExampleStub()
    {
        return __DIR__ . '/stubs/node_inslude_example.stub';
    }

    /**
     * @param string $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return 'App\Http\Node';
    }

    /**
     * @param string $stub
     * @param string $name
     * @return mixed
     */
    protected function replaceClass($stub, $name)
    {
        $stub = parent::replaceClass($stub, $name);

        if (!empty($this->option('tableExample'))) {

            $this->call('lara:model', [
                'name' => $this->argument('name') . 'Model',
                '--tableExample' => $this->option('tableExample')
            ]);
        } else {

            $this->call('lara:model', [
                'name' => $this->argument('name') . 'Model'
            ]);
        }

        return str_replace('NodeModelStud', trim($this->argument('name')), $stub);
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
