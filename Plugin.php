<?php namespace JD\DingoApi;

use Backend;
use RainLab\User\Models\User;
use System\Classes\PluginBase;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Foundation\AliasLoader;
use Tymon\JWTAuth\Middleware\RefreshToken;

/**
 * DingoApi Plugin Information File
 */
class Plugin extends PluginBase
{
    public $require = ['RainLab.User'];

    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'DingoApi',
            'description' => 'Dingo API implemention with RainLab.User',
            'author'      => 'JD',
            'icon'        => 'icon-leaf'
        ];
    }

    /**
     * Register method, called when the plugin is first registered.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(\Dingo\Api\Provider\LaravelServiceProvider::class);
        $this->app->register(\Tymon\JWTAuth\Providers\JWTAuthServiceProvider::class);
        
        $this->app->singleton('jd.dingoapi.auth', function() {
            return \JD\DingoApi\Classes\AuthManager::instance();
        });

        $alias = AliasLoader::getInstance();
        $alias->alias('JWTAuth', \Tymon\JWTAuth\Facades\JWTAuth::class);
        $alias->alias('JWTFactory', \Tymon\JWTAuth\Facades\JWTFactory::class);

        $this->app['config']['jwt'] = require __DIR__ . '/config/jwt.php';
        $this->app['config']['api'] = require __DIR__ . '/config/api.php';
    }

    /**
     * Boot method, called right before the request route.
     *
     * @return array
     */
    public function boot()
    {
        $this->app['router']->middleware('jwt.auth', '\Tymon\JWTAuth\Middleware\GetUserFromToken');
        $this->app['router']->middleware('jwt.refresh', '\Tymon\JWTAuth\Middleware\RefreshToken');

        $this->app['Dingo\Api\Auth\Auth']->extend('jwt', function ($app) {
            return new \Dingo\Api\Auth\Provider\JWT($app['Tymon\JWTAuth\JWTAuth']);
        });
    }

}
