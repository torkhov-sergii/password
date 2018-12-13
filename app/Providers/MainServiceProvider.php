<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class MainServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //admin
        view()->composer('admin.header', 'App\Http\ViewComposers\LangComposer');

        view()->composer('admin.sidebar', 'App\Http\ViewComposers\AdminMainMenuComposer');

        //site
        view()->composer('header', 'App\Http\ViewComposers\LangComposer');
        view()->composer(['header','pages.main'], 'App\Http\ViewComposers\MenuComposer');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register() {

    }
}
