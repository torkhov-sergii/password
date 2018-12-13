<?php namespace App\Http\ViewComposers;

use Request;
use Illuminate\Contracts\View\View;
use App\Models\Main;
use Session;
use Auth;

class AdminMainMenuComposer {

    public function compose(View $view) {
        $selected_category = Request::get('selected_category');

        $mainModel = new Main;

        $selected_node = null;
        $opened_categories = [];

        $root = $mainModel->getRootNode();

        $user = Auth::user();
        $allowCategories = $user->getAllowCategories();

        $categories = $root->descendants()
            ->query(['with'=>'type','result'=>'','show_hidden'=>true])
            ->leftJoin('type', function ($join) {
                $join->on('main.type_id', '=', 'type.id');
            })
            ->where('isShowInMenu', 1)
            ->when(count($allowCategories), function($query) use ($allowCategories) {
                return $query->whereIn('main.id', $allowCategories);
            })
            ->orderBy('main_id')
            //->select('main.*')
            ->get()
            ->toHierarchy();

        if($selected_category) {
            $selected_node = $mainModel->findOrFail($selected_category);

            //массив айдишек открытых меню
            $opened_categories = $selected_node
                ->ancestorsAndSelf()
                ->get()
                ->pluck('id')
                ->toArray();
        }

        $view->with('category', $selected_node);
        $view->with('selected_category', $selected_category);
        $view->with('categories', $categories);
        $view->with('opened_categories', $opened_categories);
    }
}