<?php

namespace Trafik8787\LaraCrud;


use Illuminate\Support\ServiceProvider;
use Trafik8787\LaraCrud\Contracts\AdminInterface;
use Trafik8787\LaraCrud\Contracts\Component\ComponentManagerBuilderInterface;
use Trafik8787\LaraCrud\Contracts\Component\TabsInterface;
use Trafik8787\LaraCrud\Contracts\FormManagerInterface;
use Trafik8787\LaraCrud\Contracts\Navigation\NavigationInterface;
use Trafik8787\LaraCrud\Contracts\NodeModelConfigurationInterface;
use Trafik8787\LaraCrud\Contracts\TableInterface;
use Trafik8787\LaraCrud\Form\Component\ComponentManagerBuilder;
use Trafik8787\LaraCrud\Form\Component\Tabs;
use Trafik8787\LaraCrud\Form\FormTable;
use Trafik8787\LaraCrud\Models\NodeModelConfiguration;
use Trafik8787\LaraCrud\Navigation\Navigation;
use Trafik8787\LaraCrud\Table\DataTable;


class LaraCrudProvider extends ServiceProvider
{

    protected $navigation = [];
    protected $nodes = [];


    public function nodes ()
    {
        return $this->nodes;
    }

    public function navigation ()
    {
        return $this->navigation;
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
        view()->composer('lara::common.header', Navigation::class);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

        $this->app->singleton(AdminInterface::class, function (){
            return new Admin($this->nodes(), $this->navigation(), $this->app);
        });

        $this->app->singleton(NodeModelConfigurationInterface::class, NodeModelConfiguration::class);
        $this->app->singleton(FormManagerInterface::class, FormTable::class);
        $this->app->singleton(TableInterface::class, DataTable::class);
        $this->app->singleton(ComponentManagerBuilderInterface::class, ComponentManagerBuilder::class);
        $this->app->singleton(TabsInterface::class, Tabs::class);


    }

}
