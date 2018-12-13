<?php namespace App\Widgets\Admin;

use Arrilot\Widgets\AbstractWidget;
use App\Models\Main;
use View;
use Request;

class Breadcrumbs extends AbstractWidget {

    protected $config = [];
    public $cacheTime = 0;

    public function run()
    {
        $selected_category = Request::get('selected_category');

        $mainModel = new Main;

        //breadcrumbs
        if($selected_category) {
            $selected_node = $mainModel->findOrFail($selected_category);
            //$breadcrumbs = $selected_node->ancestorsAndSelf()->withoutRoot()->query(['with'=>'','result'=>''])->get()->all();
            $breadcrumbs = $selected_node->ancestorsAndSelf()->withoutRoot()->query(['with'=>'','result'=>''])->get()->toHierarchy();
        }

        return View::make('widgets.admin.breadcrumbs', compact('breadcrumbs'));
    }
}