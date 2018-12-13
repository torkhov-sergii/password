<?php namespace App\Http\Controllers;

use App\Models\Main;
use App\Transformers\CourseTransformer;
use Baum\Node;
use Illuminate\Http\Request;
use App\Http\Requests;
use View;
use Flash;
use Session;
use Illuminate\Support\Facades\Input;
use Settings;

class RedirectController extends Controller {

    public function specificationsIndex() {
        return redirect('http://infobox.prozorro.org/specifications');
    }

    public function specificationsItem($id) {
        return redirect('http://infobox.prozorro.org/specifications/product/'.$id.'/view');
    }

    public function specificationsConstructor($id) {
        return redirect('http://infobox.prozorro.org/specifications/constructor/'.$id);
    }

}
