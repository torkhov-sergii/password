<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map(Request $request)
    {
        $this->mapApiRoutes($request);

        $this->mapWebRoutes($request);

        //
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes($request)
    {
        $locales = $this->app->config->get('app.locales');
        if (count($locales)>1) {
            $locale = $request->segment(1);
            $this->app->setLocale($locale);

            Route::middleware('web')
                ->namespace($this->namespace)
                ->prefix($locale)
                ->group(base_path('routes/web.php'));
        } else {
            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/web.php'));
        }
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes($request)
    {
//        Route::prefix('api')
//             ->middleware('api')
//             ->namespace($this->namespace)
//             ->group(base_path('routes/api.php'));

        $locales = $this->app->config->get('app.locales');
        if (count($locales)>1) {
            $locale = $request->segment(1);
            $this->app->setLocale($locale);

            Route::middleware('api')
                ->namespace($this->namespace)
                ->prefix($locale.'/api')
                ->group(base_path('routes/api.php'));
        } else {
            Route::middleware('api')
                ->namespace($this->namespace)
                ->prefix('api')
                ->group(base_path('routes/api.php'));
        }
    }
}
