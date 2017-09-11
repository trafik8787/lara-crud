<?php

namespace Trafik8787\LaraCrud;

use Illuminate\Contracts\Routing\Registrar;
use Illuminate\Routing\Route;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;


class LaraCrudProvider extends ServiceProvider
{

    protected $nodes = [];


    public function nodes ()
    {
        return $this->nodes;
    }


    public function boot(Admin $admin)
    {

        $this->loadViewsFrom(__DIR__ . '/resources/views', 'lara');
        $this->mergeConfigFrom(__DIR__ . '/config/config.php', 'lara-config');
        $this->loadTranslationsFrom(__DIR__ . '/lang', 'lara-crud');
        $this->loadRoutesFrom(__DIR__ . '/src/routes.php');


        $admin->initNode($this->nodes());

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {


    }

}
