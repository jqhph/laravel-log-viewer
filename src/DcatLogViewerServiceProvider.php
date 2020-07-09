<?php

namespace Dcat\LogViewer;

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
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
        Route::group([
            'prefix' => config('dcat-log-viewer.route.prefix', 'dcat-logs'),
            'namespace' => config('dcat-log-viewer.route.namespace', 'Dcat\LogViewer'),
            'middleware' => config('dcat-log-viewer.route.middleware'),
        ], function (Router $router) {
            $router->get('/', 'LogController@index')->name('dcat-log-viewer');
            $router->get('{file}', 'LogController@index')->name('dcat-log-viewer.file');
            $router->get('download/{file}', 'LogController@download')->name('dcat-log-viewer.download');
        });
    }
}
