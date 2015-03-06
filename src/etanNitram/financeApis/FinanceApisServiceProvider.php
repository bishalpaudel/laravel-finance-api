<?php namespace EtanNitram\FinanceApis;

use Illuminate\Support\ServiceProvider;

class FinanceApisServiceProvider extends ServiceProvider {

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->package('etannitram/financeapis');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $controller = __DIR__ . '../../../controllers/FinanceQuotes';        
        $this->app->register($controller);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array();
    }
}