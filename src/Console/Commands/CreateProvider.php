<?php
/**
 * Created by PhpStorm.
 * User: Vitalik
 * Date: 13.01.2018
 * Time: 16:06
 */
namespace Trafik8787\LaraCrud\Console\Commands;


class CreateProvider extends Installer {



    /**
     * Установка компонентов текущей конфигурации.
     *
     * @return void
     */

    public function showInfo()
    {
        // TODO: Implement showInfo() method.
    }

    public function install()
    {

        $file = $this->getFilePath();
        $ns = rtrim($this->command->getLaravel()->getNamespace(), '\\');

        $contents = str_replace(
            '__NAMESPACE__',
            $ns,
            $this->command->files()->get(SLEEPINGOWL_STUB_PATH.'/provider.stub')
        );

        $this->command->files()->put($file, $contents);
    }

    /**
     * При возврате методом true данный компонент будет пропущен.
     *
     * @return bool
     */
    public function installed()
    {
        return file_exists($this->getFilePath());
    }

    /**
     * @return string
     */
    protected function getFilePath()
    {
        return app_path('Providers/LaraCrudProvider.php');
    }




//    protected $name = 'lara:provider:make';
//
//    /**
//     * The console command description.
//     *
//     * @var string
//     */
//    protected $description = 'Create a new provider class';
//
//    /**
//     * The type of class being generated.
//     *
//     * @var string
//     */
//    protected $type = 'Provider';
//
//    protected function alreadyExists($rawName)
//    {
//        return class_exists($rawName);
//    }
//
//    public function getStub ()
//    {
//        return __DIR__.'/stubs/provider.stub';
//    }
//
//    protected function getDefaultNamespace($rootNamespace)
//    {
//        return 'App\Providers';
//    }
//
//    protected function replaceClass($stub, $name)
//    {
//        $stub = parent::replaceClass($stub, $name);
//        return str_replace('NameProvider', trim($this->argument('model')), $stub);
//    }
//
//    protected function getArguments()
//    {
//        $arguments = parent::getArguments();
//        $arguments[] = ['model', InputArgument::REQUIRED, 'The name of the provider class'];
//
//        return $arguments;
//    }

}