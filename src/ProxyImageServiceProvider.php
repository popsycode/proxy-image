<?php
/**
 * Created by PhpStorm.
 * User: POPsy
 * Date: 28.07.2018
 * Time: 0:23
 */

namespace POPsy\ProxyImage;


use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class ProxyImageServiceProvider extends ServiceProvider
{
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
        // Publish config files
        $this->publishes([
            __DIR__.'/../config/config.php' => app()->basePath() . '/config/proxy-image.php',
        ], 'proxy-image');

    }
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerProxyImage();
        $this->mergeConfig();
        $this->loadAssets();
    }

    /**
     * Register the application bindings.
     *
     * @return void
     */
    private function registerProxyImage()
    {
        $this->app->bind('proxy-image', function ($app) {
            return new ProxyImage($app);
        });
        $this->app->alias('proxy-image', 'POPsy\ProxyImage\ProxyImage');
    }

    /**
     * Load assets.
     */
    protected function loadAssets()
    {
        $this->publishes([
            __DIR__.'/../public' => public_path('vendor'),
        ], 'proxy-image');
    }

    /**
     * Merges user's and entrust's configs.
     *
     * @return void
     */
    private function mergeConfig()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/config.php', 'proxy-image'
        );
    }

}