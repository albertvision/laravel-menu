<?php

namespace YGeorgiev\Menu;

use App;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

class MenuServiceProvider extends ServiceProvider {

    /**
     * Name of the Laravel package.
     *
     * @var string
     */
    private static $_packageName = 'menu';

    /**
     * Returns the name of the package.
     *
     * @return string
     */
    public static function getPackageName() {
        return self::$_packageName;
    }

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    public function boot() {
        $this->app->register('Collective\Html\HtmlServiceProvider');
        $aliases = [
            'HTML' => 'Collective\Html\HtmlFacade',
            'Form' => 'Collective\Html\FormFacade',
        ];
        AliasLoader::getInstance($aliases)->register();

        $this->loadViewsFrom(__DIR__.'/Application/views', self::$_packageName);
        $this->publishes([
            __DIR__.'/Application/views' => base_path('resources/views/vendor/'.self::$_packageName),
            __DIR__.'/Application/Support' => app_path('Support')
        ]);

        if(!App::runningInConsole() && file_exists($supportFile = app_path('Support/Menu.php'))) {
            include_once $supportFile;
        }
    }

    public function register() {
        $this->app[self::$_packageName] = $this->app->share(function($app) {
            return new Menu($app['view'], $app['config']);
        });
    }

    public function provides() {
        return [self::$_packageName];
    }
}
