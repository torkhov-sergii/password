<?php namespace App\Http\Controllers;

use App\Models\Main;
use App\Models\Tag;
use Illuminate\Http\Request;
use App\Http\Requests;
use View;
use App\Transformers\ArticleTransformer;
use JavaScript;

class FiltersController extends Controller {

    public function getAjaxFilters(Request $request, Main $mainModel) {
        $type = $request->get('type');

        $chapters = null;
        $types = null;
        $whoms = null;
        $durations = null;
        $difficulties = null;
        $tags = null;

        if ($type == 'articles') {
            $chapters = Main::where('main.type_id', '=', 19)->query(['with'=>'','result'=>'get','sort'=>'sort']);
            $chapters->prepend(['name'=>'Всі статті']);

            $types = Main::where('main.type_id', '=', 20)->query(['with'=>'','result'=>'get','sort'=>'sort']);
            $types->prepend(['name'=>'Всі типи']);

            $tags = Tag::all();
        }

        if ($type == 'news' || $type == 'news-mert') {
            $tags = Tag::all();
        }

        if ($type == 'courses') {
            $whoms = ([
                ['id'=>null, 'name'=>'Всі курси'],
                ['id'=>3, 'name'=>'Журналістам'],
                ['id'=>2, 'name'=>'Учаснику'],
                ['id'=>1, 'name'=>'Замовнику'],
            ]);

            $durations = ([
                ['id'=>null, 'name'=>'Всі курси'],
                ['id'=>1, 'name'=>'1 день'],
                ['id'=>2, 'name'=>'2-3 дня'],
                ['id'=>3, 'name'=>'Більше 3-х днів'],
            ]);
        }

        if ($type == 'courses' || $type == 'articles') {
            $difficulties = ([
                ['id'=>null, 'name'=>'Всі'],
                ['id'=>1, 'name'=>'Легкий'],
                ['id'=>2, 'name'=>'Середній'],
                ['id'=>3, 'name'=>'Високий'],
            ]);
        }

        return response()->json([
            'chapters' => $chapters,
            'types' => $types,
            'whoms' => $whoms,
            'durations' => $durations,
            'difficulties' => $difficulties,
            'tags' => $tags,
        ], 200);
    }

}
