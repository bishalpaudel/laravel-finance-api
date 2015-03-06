<?php namespace EtanNitram\FinanceApis;

use Illuminate\Support\ServiceProvider;

class FinanceApisServiceProvider extends ServiceProvider {

    private $packageName = 'etanNitram/financeApis';

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
        $this->package($this->packageName);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $configPath = __DIR__ . '../../config/financeApi.php';
        $this->app['config']->package($this->packageName, $configPath);
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