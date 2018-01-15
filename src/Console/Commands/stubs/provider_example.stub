<?php

namespace App\Providers;

use Trafik8787\LaraCrud\LaraCrudProvider as ServiceProvider;

class LaraCrudProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */

    protected $navigation = [

        'App\Http\Node\ArticleExample' => [
            'priory' => 2,
            'title' => 'Article',
            'icon' => 'fa-tree'
        ]
    ];

    protected $nodes = [
        'App\Http\Node\Model\ArticleExampleModel'         => 'App\Http\Node\ArticleExample',
    ];

    public function boot()
    {

    }

}
