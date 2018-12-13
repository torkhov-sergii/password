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

class SeoController extends Controller {

    public function index(Type $typeModel) {
        $root = $typeModel->getRootNode();
        $items = $root->getDescendants()->where('isSeo', 1)->toHierarchy();

        /* for using without Translatable
        $locale = \App::getLocale();
        $items = $root->descendants()
            ->where('isSeo', 1)
            ->leftJoin('type_translations', function ($join) use ($locale) {
                $join->on('type.id', '=', 'type_translations.type_id')
                    ->where('locale', '=', $locale);
            })->get()->toHierarchy();

        */

        return View::make('admin/seo/main', compact('items'));
    }

    public function update(Request $request) {
        $locale = \App::getLocale();

        $setting_fields = ['global_title_' . $locale, 'global_description_' . $locale, 'global_keywords_' . $locale, 'global_twitter_site_' . $locale, 'global_twitter_creator_' . $locale, 'global_og_site_name_' . $locale, 'global_fb_admins_' . $locale];

        foreach ($setting_fields as $setting_field) {
            if($request->get($setting_field)) Settings::set($setting_field, $request->get($setting_field));
        }

        $data = Input::except(array_merge($setting_fields, ['_token']));
        foreach ($data as $item_id => $item_meta) {
            //$item = Type::findOrFail($item_id);
            //$item->update($data[$item_id]);
            $type_translations = TypeTranslation::where('type_id', '=', $item_id)->where('locale', '=', $locale)->first();

            if($type_translations) {
                $type_translations->update($item_meta);

            } else {
                $item_meta['type_id'] = $item_id;
                $item_meta['locale'] = $locale;

                TypeTranslation::insert($item_meta);
            }

        }

        Settings::save();

        Flash::success('Saved successfully');
        return \Redirect::back();
    }

}
