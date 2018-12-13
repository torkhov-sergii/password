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

class CoursesController extends Controller {

    public function getCourses(Main $mainModel) {
        return View::make('courses.index');
    }

    public function getCourseItem(Main $mainModel, $slug) {
        $item = $mainModel::where('slug', '=', $slug)->query(['seo'=>true,'result'=>'first']);

        return View::make('courses.view', compact('item'));
    }

    public function getAjaxCourses(Request $request, Main $mainModel) {
        $perPage = $request->get('perPage');
        $filtersData = $request->get('filtersData');

        $whom = $filtersData['whom'];
        $duration = $filtersData['duration'];
        $difficulty = $filtersData['difficulty'];

        $query = Main::where('main.type_id', '=', 24)->orderBy('date', 'desc');

        if ($whom) {
            $query->where('select1', $whom);
        }

        if ($duration) {
            if ($duration == 1) $query->where('string2', '=', $duration);
            elseif ($duration == 2) $query->where('string2', '>=', 2)->where('string2', '<=', 3);
            elseif ($duration == 3) $query->where('string2', '>', $duration);
        }

        if ($difficulty) {
            $query->where('select3', $difficulty);
        }

        $items = $query->query(['seo'=>false,'result'=>'paginate:'.$perPage]);

        return response()->json([
            'lastPage' => $items->lastPage(),
            'items' => fractal()
                ->collection($items)
                ->transformWith(new CourseTransformer())
        ]);
    }

}
