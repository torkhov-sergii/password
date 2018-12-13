<?php namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Main;
use App\Models\Tag;
use Illuminate\Http\Request;
use App\Http\Requests;
use View;
use Flash;
use DB;

class TagController extends Controller {

    public function index(Tag $tagModels)	{
        $tags = $tagModels->all();

        return View::make('admin.tag.main', compact('tags'));
    }

    //get /admin/type/{$id}/edit
    public function edit(Tag $tagModels, $id) {
        $tag = $tagModels->findOrFail($id);

        return view('admin.tag.edit', compact('tag'));
    }

    public function update(Request $request, Tag $tagModels, $id) {
        $data = $request->except(['_token']);

        $tag = $tagModels->findOrFail($id);

        $tag->update($data);

        Flash::success('Сохранено успешно');
        return \Redirect::back();
    }

    public function destroy(Request $request, $id) {
        $tag = Tag::findOrFail($id);

        $tag->delete();

        return \Redirect::back();
    }

    public function getAjaxTags(Request $request, $type = null) {
        $q = $request->get('q');
        $table = $request->get('table');
        $type_id = $request->get('type_id');
        $parent_id = $request->get('parent_id');

        if($table == 'main') {
            $query = Main::where('name', 'LIKE', '%'.$q.'%')->query()->limit(500);

            if($type_id) {
                $query->where('type_id', $type_id);
            }

            if($parent_id) {
                $query->where('parent_id', $parent_id);
            }

            $pluck = ['id','name'];
        }
        else {
            $query = DB::table($table)->where('name', 'LIKE', '%'.$q.'%')->limit(500);
            $pluck = ['name','name'];
        }

        $items = $query->orderBy('name')->get();

        if(!count($items)) {
            return response()->json(['items'=>[['id'=>1, 'text'=>'not found']]]);
        }

        foreach ($items as $item) {
            $tags2[] = ['id'=>$item->{$pluck[0]}, 'text'=>$item->{$pluck[1]}];
        }

        return response()->json(['items'=>$tags2]);
    }

}
