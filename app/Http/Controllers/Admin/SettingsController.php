<?php namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Type;
use View;
use Flash;
use Illuminate\Support\Facades\Input;
use Settings;
use App\Models\TypeTranslation;
use DB;

class SettingsController extends Controller {

    public function index(Type $typeModel) {
        return View::make('admin.settings.main');
    }

    public function update(Request $request) {
        $data = $request->except(['_token','_method']);

        foreach ($data as $key => $val) {
            Settings::set($key, $val);
        }

        Settings::save();

        Flash::success('Saved successfully');
        return \Redirect::back();
    }

}
