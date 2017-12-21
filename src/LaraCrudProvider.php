<?php

namespace Trafik8787\LaraCrud;


use Illuminate\Support\ServiceProvider;
use Trafik8787\LaraCrud\Contracts\AdminInterface;
use Trafik8787\LaraCrud\Contracts\Component\ComponentManagerBuilderInterface;
use Trafik8787\LaraCrud\Contracts\Component\TabsInterface;
use Trafik8787\LaraCrud\Contracts\Component\UploadFileInterface;
use Trafik8787\LaraCrud\Contracts\FormManagerInterface;
use Trafik8787\LaraCrud\Contracts\Model\ModelRouterInterface;
use Trafik8787\LaraCrud\Contracts\NodeModelConfigurationInterface;
use Trafik8787\LaraCrud\Contracts\TableInterface;
use Trafik8787\LaraCrud\Form\Component\ComponentManagerBuilder;
use Trafik8787\LaraCrud\Form\Component\Tabs;
use Trafik8787\LaraCrud\Form\FormTable;
use Trafik8787\LaraCrud\Form\UploadFile;
use Trafik8787\LaraCrud\Models\ModelRouter;
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

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'lara');
        $this->mergeConfigFrom(__DIR__ . '/../config/lara-config.php', 'lara-config');
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'lara-crud');
        $this->loadRoutesFrom(__DIR__ . '/routes.php');

        $this->publishes([
            __DIR__ . '/../resources/assets' => public_path('vendor/lara-crud'),
        ], 'public');

        $this->publishes([
            __DIR__ . '/../config/lara-config.php' => config_path('lara-config.php'),
        ], 'config');

        view()->composer('lara::common.header', Navigation::class);
    }

    /**
     * @param $key
     * @return mixed
     */
    protected function getConfig($key)
    {
        return $this->app['config']->get('lara-config.'.$key);
    }
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerCommands();

        $this->app->singleton(AdminInterface::class, function (){
            return new Admin($this->nodes(), $this->navigation(), $this->app);
        });

        $this->app->singleton(ModelRouterInterface::class, ModelRouter::class);
        $this->app->singleton(NodeModelConfigurationInterface::class, NodeModelConfiguration::class);
        $this->app->singleton(FormManagerInterface::class, FormTable::class);
        $this->app->singleton(TableInterface::class, DataTable::class);
        $this->app->singleton(ComponentManagerBuilderInterface::class, ComponentManagerBuilder::class);
        $this->app->singleton(TabsInterface::class, Tabs::class);
        $this->app->singleton(UploadFileInterface::class, UploadFile::class);


    }


    /**
     *
     */
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
