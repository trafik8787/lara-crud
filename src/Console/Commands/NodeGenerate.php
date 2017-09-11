<?php

namespace Trafik8787\LaraCrud\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputArgument;

class NodeGenerate extends GeneratorCommand
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lara:node {name} {--model=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';



    public function getStub ()
    {
        return __DIR__.'/stubs/node.stub';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return 'App\Http\Node';
    }

    protected function replaceClass($stub, $name)
    {
        $stub = parent::replaceClass($stub, $name);

        if ($this->option('model') !== null) {
            $this->call('make:model', [
                'name' => 'App\Http\Node\Model\\'.$this->option('model')
            ]);
        } else {
            $this->call('make:model', [
                'name' => 'App\Http\Node\Model\\'.$this->argument('name').'Model'
            ]);
        }

        return str_replace('NodeModelStud', trim($this->argument('name')), $stub);
    }

    protected function getArguments()
    {
        $arguments = parent::getArguments();
        $arguments[] = ['name', InputArgument::REQUIRED, 'The name of the model class'];

        return $arguments;
    }
    /**
     * Execute the console command.
     *
     * @return mixed
     */
//    public function handle()
//    {
////        if ($this->option('model') !== null) {
////
////            $this->call('make:model', [
////                'name' => 'App\Http\Node\Model\\'.$this->option('model')
////            ]);
////
////        } else {
////            $this->call('make:model', [
////                'name' => 'App\Http\Node\Model\\'.$this->argument('name').'Model'
////            ]);
////        }
//        $this->info('sdfsdfsdf');
//   }
}
