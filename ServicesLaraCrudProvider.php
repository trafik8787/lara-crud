<?php

namespace Trafik8787\LaraCrud;


use Trafik8787\LaraCrud\Contracts\AdminInterface;
use Trafik8787\LaraCrud\Contracts\FormManagerInterface;
use Trafik8787\LaraCrud\Contracts\NodeModelConfigurationInterface;
use Trafik8787\LaraCrud\Contracts\TableInterface;
use Trafik8787\LaraCrud\Form\FormTable;
use Trafik8787\LaraCrud\Models\NodeModelConfiguration;
use Trafik8787\LaraCrud\Table\DataTable;

class ServicesLaraCrudProvider extends LaraCrudProvider
{



//    public function boot(AdminInterface $admin)
//    {
//
//        parent::boot($admin);
//    }


    public function register()
    {

        $this->registerCommands();
    }



    protected function getConfig($key)
    {
        return $this->app['config']->get('lara-config.'.$key);
    }

    protected function registerCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                \Trafik8787\LaraCrud\Console\Commands\NodeGenerate::class,
                \Trafik8787\LaraCrud\Console\Commands\ModelGenerate::class
            ]);
        }
    }
}
