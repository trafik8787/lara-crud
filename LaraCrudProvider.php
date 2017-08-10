<?php

namespace Trafik8787\LaraCrud;

use Illuminate\Support\ServiceProvider;

class LaraCrudProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->mergeConfigFrom(__DIR__ . '/config/config.php', 'config');
        $this->loadTranslationsFrom(__DIR__ . '/lang', 'lara-crud');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
