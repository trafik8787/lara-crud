<?php

namespace Trafik8787\LaraCrud;


use function foo\func;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Routing\Route;
use Illuminate\Routing\Router;
use Illuminate\Support\Collection;
use Trafik8787\LaraCrud\Admin;
use Trafik8787\LaraCrud\Models\ModelCollection;
use Trafik8787\LaraCrud\Models\ModelRouter;
use Illuminate\Contracts\Routing\Registrar as RegistrarContract;
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
        $this->app->instance('lara_admin_datatable', new DataTable($this->app));
        $this->app->instance('lara_admin', $this->admin = new Admin($this->app));

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
                \Trafik8787\LaraCrud\Console\Commands\NodeGenerate::class
            ]);
        }
    }
}
