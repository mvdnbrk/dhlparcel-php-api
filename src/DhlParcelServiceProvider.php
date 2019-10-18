<?php

namespace Mvdnbrk\DhlParcel;

use Illuminate\Support\ServiceProvider;

class DhlParcelServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPublishing();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/dhlparcel.php', 'dhlparcel');

        $this->app->singleton(Client::class, function () {
            return (new Client)->setUserId(
                config('dhlparcel.id')
            )->setApiKey(
                config('dhlparcel.secret')
            );
        });

        $this->app->alias(Client::class, 'dhlparcel');
    }

    /**
     * Register the publishable resources for this package.
     *
     * @return void
     */
    private function registerPublishing()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/dhlparcel.php' => config_path('dhlparcel.php'),
            ], 'config');
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['dhlparcel'];
    }
}
