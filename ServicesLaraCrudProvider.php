<?php

namespace Trafik8787\LaraCrud;


use Trafik8787\LaraCrud\Contracts\TableInterface;
use Trafik8787\LaraCrud\Form\FormTable;
use Trafik8787\LaraCrud\Models\NodeModelConfiguration;
use Trafik8787\LaraCrud\Table\DataTable;

class ServicesLaraCrudProvider extends LaraCrudProvider
{


    private $admin;


    public function boot(Admin $admin)
    {

        parent::boot($admin);
    }


    public function register()
    {

        $this->app->singleton('lara_admin_nodemodel', function(){
            return new NodeModelConfiguration($this->app);
        });
        $this->app->singleton('lara_form', function (){
            return new FormTable($this->app);
        });
        //$this->app->instance('lara_admin_datatable',  new DataTable($this->app));
        $this->app->instance('lara_admin', $this->admin = new Admin($this->app));

        $this->app->singleton(TableInterface::class, function () {
            return new  DataTable($this->app, $this->admin);
        });


    }



    protected function getConfig($key)
    {
        return $this->app['config']->get('lara-config.'.$key);
    }

    protected function registerCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                \Trafik8787\LaraCrud\Console\Commands\NodeGenerate::class
            ]);
        }
    }
}
