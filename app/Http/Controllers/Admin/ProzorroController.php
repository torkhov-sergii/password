<?php namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Datatables;
use Flash;
use Settings;

class ProzorroController extends Controller {

    public function startBlocks() {

        $customer = unserialize(Settings::get('customer'));
        $participant = unserialize(Settings::get('participant'));
        $press = unserialize(Settings::get('press'));

        return view('admin.prozorro.start_blocks.main', compact('customer','participant','press'));
    }

    public function startBlocksSave(Request $request) {
        $data = $request->except(['_token','_method']);

        Settings::set('customer', serialize($data['customer']));
        Settings::set('participant', serialize($data['participant']));
        Settings::set('press', serialize($data['press']));

        Settings::save();

        Flash::success('Сохранено');
        return \Redirect::back();
    }

}
