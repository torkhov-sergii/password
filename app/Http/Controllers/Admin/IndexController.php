<?php namespace App\Http\Controllers\admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use View;
use Auth;


class IndexController extends Controller {

    public function index() {
//        dd(Auth::user()->hasRole('superadmin'));
        //dd(Auth::user()->can('backup'));


        return View::make('admin.main');
        //return redirect('admin/main');
    }

    public function about() {
        return View::make('admin/about');
    }
}