<?php
namespace Cambodev\Statement\Provider;

use Illuminate\Support\ServiceProvider;

class StatementServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__. '/../database/migrations' => database_path('migrations/'),
        ], 'migrations');

        include __DIR__.'/../routes/api.php';

    }

    public function register()
    {
        $this->app->make('CamboDev\Statement\Controller\BankAccountController');
    }
}
