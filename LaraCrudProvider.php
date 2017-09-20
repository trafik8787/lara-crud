<?php

namespace Trafik8787\LaraCrud;

use Illuminate\Contracts\Routing\Registrar;
use Illuminate\Routing\Route;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;
use Trafik8787\LaraCrud\Contracts\AdminInterface;
use Trafik8787\LaraCrud\Contracts\FormManagerInterface;
use Trafik8787\LaraCrud\Contracts\NodeModelConfigurationInterface;
use Trafik8787\LaraCrud\Contracts\TableInterface;
use Trafik8787\LaraCrud\Form\FormTable;
use Trafik8787\LaraCrud\Models\NodeModelConfiguration;
use Trafik8787\LaraCrud\Table\DataTable;


class LaraCrudProvider extends ServiceProvider
{

    protected $nodes = [];


    public function nodes ()
    {
        return $this->nodes;
    }


    public function boot()
    {

        $this->loadViewsFrom(__DIR__ . '/resources/views', 'lara');
        $this->mergeConfigFrom(__DIR__ . '/config/config.php', 'lara-config');
        $this->loadTranslationsFrom(__DIR__ . '/lang', 'lara-crud');
        $this->loadRoutesFrom(__DIR__ . '/src/routes.php');

        $this->publishes([
            __DIR__.'./resources/assets' => public_path('vendor/lara-crud'),
        ], 'public');

       //$admin->initNode($this->nodes());

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

        $this->app->singleton(AdminInterface::class, function (){
            return new Admin($this->nodes(), $this->app);
        });

        $this->app->singleton(NodeModelConfigurationInterface::class, NodeModelConfiguration::class);
        $this->app->singleton(FormManagerInterface::class, FormTable::class);
        $this->app->singleton(TableInterface::class, DataTable::class);

    }

}
