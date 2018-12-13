<?php namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Barryvdh\TranslationManager\Models\Translation;
use App\Http\Requests;
use Illuminate\Support\Facades\App;
use Flash;
use Cache;

class TranslationController extends \Barryvdh\TranslationManager\Controller
{

    public function getIndex($group = null)
    {
        //$locales = $this->loadLocales();
        $locales = array_keys(config('app.locales'));

        $groups = Translation::groupBy('group');
        $excludedGroups = $this->manager->getConfig('exclude_groups');
        if($excludedGroups){
            $groups->whereNotIn('group', $excludedGroups);
        }

        $groups = $groups->pluck('group', 'group');
        if ($groups instanceof Collection) {
            $groups = $groups->all();
        }
        //$groups = [''=>'Choose a group'] + $groups;
        $numChanged = Translation::where('group', $group)->where('status', Translation::STATUS_CHANGED)->count();


        $allTranslations = Translation::where('group', $group)->orderBy('key', 'asc')->get();
        $numTranslations = count($allTranslations);
        $translations = [];
        foreach($allTranslations as $translation){
            $translations[$translation->key][$translation->locale] = $translation;
        }

        return view('admin/translations/main')
            ->with('translations', $translations)
            ->with('locales', $locales)
            ->with('groups', $groups)
            ->with('group', $group)
            ->with('numTranslations', $numTranslations)
            ->with('numChanged', $numChanged)
            ->with('editUrl', route('admin.translations.edit', [$group]))
            ->with('deleteEnabled', $this->manager->getConfig('delete_enabled'));
    }

    public function postAdd($group = null)
    {
        $keys = explode("\n", request()->get('keys'));
        $value = request()->get('value');
        $locale = App::getLocale();

        foreach($keys as $key){
            $key = trim($key);
            $key = str_replace($group.'.', '', $key);

            if($group && $key){
                $this->manager->missingKey('*', $group, $key);

                //сразу сохраним перевод
                $translation = Translation::firstOrNew([
                    'locale' => $locale,
                    'group' => $group,
                    'key' => $key,
                ]);
                $translation->value = (string) $value ?: null;
                $translation->status = Translation::STATUS_CHANGED;
                $translation->save();
            }
        }

        $this->postPublish($group);

        return redirect()->back();
    }

    public function update(Request $request)
    {
        //if(!in_array($group, $this->manager->getConfig('exclude_groups'))) {
            $id = $request->get('id');
            $value = $request->get('value');
            $locale = $request->get('locale');
            $group = $request->get('group');
            $key = $request->get('key');

            $translation = Translation::firstOrNew([
                'locale' => $locale,
                'group' => $group,
                'key' => $key,
                'id' => $id,
            ]);
            $translation->value = (string) $value ?: null;
            $translation->status = Translation::STATUS_CHANGED;
            $translation->save();

            $this->postPublish($group);

            return array('status' => 'ok');
        //}
    }

    //auto translate not translated
    public function auto_translate() {

        $from = 'en';
        $langs = config('app.locales');
        $allTranslations = Translation::where('locale',$from)->limit(1000)->get();

        foreach ($langs as $to=>$lang_name) {
            $tr = new TranslateClient($from, $to);

            foreach($allTranslations as $translation){
                $value = $tr->translate($translation->value);

                $get_translation = Translation::firstOrNew([
                    'locale' => $to,
                    'group' => $translation->group,
                    'key' => $translation->key,
                ]);

                if(!$get_translation->value) {
                    echo '<br>('.$from.' → '.$to.' - '.$translation->group.' - '.$translation->key.') '.$translation->value.' → '.$value;

                    $get_translation->value = (string) $value ?: null;
                    $get_translation->status = Translation::STATUS_CHANGED;
                    $get_translation->save();
                }
            }
        }

        dd('ok');
    }

    public function delete($group, $key)
    {
        if(!in_array($group, $this->manager->getConfig('exclude_groups')) && $this->manager->getConfig('delete_enabled')) {
            Translation::where('group', $group)->where('key', $key)->delete();

            return redirect()->back();
        }
    }

    public function postPublish($group = null)
    {
        $this->manager->exportTranslations($group);

        //re-generate lang.js
        Cache::flush();

        Flash::success('Сохранено успешно');
        return redirect()->back();
    }

    //https://medium.com/@serhii.matrunchyk/using-laravel-localization-with-javascript-and-vuejs-23064d0c210e
    public function generatedLangJs()
    {
        $strings = Cache::rememberForever('lang.js', function () {
            $lang = config('app.locale');

            $files   = glob(resource_path('lang/' . $lang . '/*.php'));
            $strings = [];

            foreach ($files as $file) {
                $name           = basename($file, '.php');
                $strings[$name] = require $file;
            }

            return $strings;
        });

        header('Content-Type: text/javascript');
        echo('window.i18n = ' . json_encode($strings) . ';');
        exit();
    }
}