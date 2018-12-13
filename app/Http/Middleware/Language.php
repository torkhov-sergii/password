<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Routing\Redirector;
use Illuminate\Http\Request;
use Illuminate\Foundation\Application;
use Helpers;

class Language {

    public function __construct(Application $app, Redirector $redirector, Request $request) {
        $this->app = $app;
        $this->redirector = $redirector;
        $this->request = $request;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {

        //don't forget about RouteServiceProvider!!!

        $locales = $this->app->config->get('app.locales');

        if (count($locales)>1) {

            //не применять редирект мультиязычности на
            $notApplyTo = ['imgcache'];

            //текущая локаль
            $locale = $request->segment(1);

            if (!array_key_exists($locale, $locales) && !in_array($locale, $notApplyTo)) {
                $detect_lang = Helpers::getDefaultLanguage(); //автоопределение языка браузера
                //$detect_lang = null; //отключим автоопределение - для сбсб

                if (array_key_exists($detect_lang, $locales)) {
                    $locale_default = $detect_lang;
                } else {
                    $locale_default = $this->app->config->get('app.fallback_locale');
                }
                $segments = $request->segments();

                array_unshift($segments, $locale_default);
                return $this->redirector->to(implode('/', $segments));
            }

            $this->app->setLocale($locale);
        }

        return $next($request);
    }

}