<?php namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;

class LangComposer {

    public function compose(View $view) {

        $langs = config('app.locales');
        $lang_active =  \App::getLocale();

        $view->with('langs', $langs);
        $view->with('lang_active', $lang_active);
        $view->with('lang_active_name', $langs[$lang_active]);
    }
}