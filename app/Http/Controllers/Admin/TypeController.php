<?php namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Type;
use App\Models\Main;
use View;
use Flash;
use Illuminate\Http\Request;
use App;
use Input;
use Helpers;
use Cviebrock\EloquentSluggable\Services\SlugService;

class TypeController extends Controller {

	//get /admin/Type
	public function index(Type $typeModel) {
		$root = $typeModel->getRootNode();
		$types = $typeModel->getDescendantsTree($root);

		return View::make('admin/type/main', compact('types', 'root'));
	}

	public function create(Type $typeModel) {
		$root = $typeModel->getRootNode();
		$types = $typeModel->getDescendantsTree($root);

		return view('admin/type/create', compact('types', 'root'));
	}

	public function store(Request $request, Type $typeModel, Main $mainModel) {
		$data = $request->except(['_token','parent']);
		$parent = $request->input('parent');

        if($parent == 0) $node_parent = $typeModel->getRootNode();
        else $node_parent = $typeModel->getNodeById($parent);

        //add name by default
        $data['fields'] = 'Name->name';

		$type = Type::create($data);
		$type->makeChildOf($node_parent);


        //Дублируем в таблице main
        if($parent == 0) {
            $data['type_id'] = $type['id'];
            $main_node = $mainModel->where('type_id',$type['parent_id'])->first();

            if($parent == 0) $main_node_parent = $mainModel->getRootNode();
            else $main_node_parent = $mainModel->getNodeById($main_node['id']);

            //создаем элемент в main
            //$data['slug'] = Main::createSlug($data['name']);
            $data['slug'] = SlugService::createSlug(Main::class, 'slug', $data['name']);

            //сортировка
            $max_sort = Main::max('sort');
            $data['sort'] = $max_sort+1;

            $main = Main::create($data);
            $main->updateTranslations($data);
            $main->makeChildOf($main_node_parent);
        }

		Flash::success('Item was added');
		return redirect()->route('admin.type.index');
	}

	public function show($id) {
		//
	}

	//get /admin/type/{$id}/edit
	public function edit(Type $typeModel, $id) {
		$type = $typeModel->getNodeById($id);

        $root = $typeModel->getRootNode();
        $types = $typeModel->getDescendantsTree($root);

        $fields = $type['fields'];
        $fields = str_replace(';',"\r\n",$fields);
        $type['fields'] = $fields;

        $fields = $type['fields_aside'];
        $fields = str_replace(';',"\r\n",$fields);
        $type['fields_aside'] = $fields;

        return view('admin/type/edit', compact('type','types'));
	}

	//post /admin/type/{$id}
	public function update(Type $typeModel, $id) {
		$typeModel->getNodeById($id)->postNode();

        Flash::success('Saved successfully');
		//return \Redirect::back();
        return redirect()->route('admin.type.index');
	}

	//destroy /admin/type/{$id}
	public function destroy(Type $typeModel, Main $mainModel, $id) {
		$node = $typeModel->getNodeById($id);
		$typeModel->destroyNode($node);

        //Удаляем так же из таблицы main
        if($id) {
            $main_node = $mainModel->where('type_id',$id)->first();
            if($main_node) $mainModel->destroyNode($main_node);
        }

		Flash::success('Item was removed');
		return \Redirect::back();
	}

//заменил все тегами
//    //добавить или удалить связь элементов
//    public function relate(Main $mainController) {
//        $data = Input::except('_token', 'fields', 'relate_with');
//
//        $node1 = $mainController->getNodeById($data['id1']);
//        $node2 = $mainController->getNodeById($data['id2']);
//
//        if($data['action'] == 'true') {
//            $node1->relate()->attach([$data['id2']]);
//            $node2->relate()->attach([$data['id1']]);
//        }
//        else {
//            $node1->relate()->detach($data['id2']);
//            $node2->relate()->detach($data['id1']);
//        }
//    }
}
