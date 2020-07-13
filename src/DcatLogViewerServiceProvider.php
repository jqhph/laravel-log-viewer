<?php

namespace Dcat\LogViewer;

use Illuminate\Support\ServiceProvider;

class DcatLogViewerServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/view', 'dcat-log-viewer');

        if ($this->app->runningInConsole()) {
            $this->publishes([__DIR__.'/../config' => config_path()], 'dcat-log-viewer');
        }

        $this->registerRoutes();
    }

    protected function registerRoutes()
    {
        app('router')->group([
            'prefix' => config('dcat-log-viewer.route.prefix', 'dcat-logs'),
            'namespace' => config('dcat-log-viewer.route.namespace', 'Dcat\LogViewer'),
            'middleware' => config('dcat-log-viewer.route.middleware'),
        ], function ($router) {
            $router->get('/', ['as' => 'dcat-log-viewer', 'uses' => 'LogController@index',]);
            $router->get('download', ['as' => 'dcat-log-viewer.download', 'uses' => 'LogController@download',]);
            $router->get('{file}', ['as' => 'dcat-log-viewer.file', 'uses' => 'LogController@index',]);
        });
    }
}
