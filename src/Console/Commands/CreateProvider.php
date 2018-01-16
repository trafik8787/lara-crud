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

    /**
     *
     */
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

}