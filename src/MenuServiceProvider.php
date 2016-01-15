<?php

namespace YGeorgiev\Menu;

use App;

use Illuminate\Support\ServiceProvider;

class MenuServiceProvider extends ServiceProvider {
    public function boot() {
        $this->loadViewsFrom(__DIR__.'/Application/views', 'menu');
        $this->publishes([
            __DIR__.'/Application/views' => base_path('resources/views/vendor/menu'),
            __DIR__.'/Application/Support' => app_path('Support')
        ]);

        if(!App::runningInConsole() && file_exists($supportFile = app_path('Support/Menu.php'))) {
            include_once $supportFile;
        }
    }

    public function register() {
        $this->app->singleton(Menu::class, function($app) {
            return new Menu($app['view'], $app['config']);
        });
        $this->app->alias(Menu::class, 'menu');
    }
}
