<?php namespace Geeky\Database;

use Illuminate\Support\ServiceProvider;

class CacheBuilderServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        
        if ($this->app->runningInConsole()) {
            $this->commands([
                ClearBuilderCache::class,
            ]);
        }

        $this->publishes([
          __DIR__.'/config/cachebuilder.php' => config_path('cachebuilder.php'),
      ]);

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }
}
