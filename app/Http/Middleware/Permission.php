<?php namespace App\Http\Middleware;

use Closure;
use Request;

class Permission {

    public function handle($request, Closure $next, $permission) {

        if(!auth()->check()) {
            return redirect()->route('login');
        }

        if (auth()->check() && auth()->user()->can($permission)) {
            return $next($request);
        }
        else {

            if(strpos(Request::url(), '/admin/') > -1) {
                return redirect()->route('admin.index')->withErrors(['You don\'t have permission']);
            }
            else {
                $request->session()->invalidate();
                return redirect()->route('login')->withErrors(['You don\'t have access to the admin panel']);
            }

        }


//        //ошибка зацикливание редиректа на /admin если пользователю не разрешено туда заходить
//        //$tmp = explode('/', redirect()->back()->getTargetUrl());
//        $tmp = explode('/', Request::url());
//        $tmp = explode('/', redirect()->back()->getTargetUrl());
//
//        if(count($tmp) == 5 && $tmp[4] == 'admin') {
//            return redirect()->guest('/');
//        }
//        else {
//            return redirect()->route('admin.index');
//        }
    }
}