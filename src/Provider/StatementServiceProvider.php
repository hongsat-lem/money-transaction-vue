<?php
namespace Cambodev\Statement\Provider;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class StatementServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            // Publish migrations
            $this->publishes([
                __DIR__. '/../database/migrations' => database_path('migrations/'),
            ], 'migrations');

            // Publish views
            $this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/statement'),
            ], 'views');

            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('statement.php'),
            ], 'config');


        }
        //routes
        $this->registerRoutes();

        // resources views
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'statement');
    }

    public function register()
    {
        //$this->app->make('CamboDev\Statement\Controller\BankAccountController');
        //$this->mergeConfigFrom(__DIR__.'/../config/config.php', 'statement');
    }

    protected function registerRoutes()
    {
        Route::group($this->routeConfiguration(), function () {
            $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        });
    }

    protected function routeConfiguration()
    {
        return [
            'prefix' => config('statement.prefix'),
            'middleware' => config('statement.middleware'),
        ];
    }
}
