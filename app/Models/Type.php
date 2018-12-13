<?php namespace App\Models;

use Baum\Node;
use Illuminate\Support\Facades\Input;
use Dimsav\Translatable\Translatable;

class Type extends Node {

    use Translatable;

    protected $table = 'type';
    protected $parentColumn = 'parent_id';
    protected $leftColumn = 'lft';
    protected $rightColumn = 'rgt';
    protected $depthColumn = 'depth';
    protected $orderColumn = null;
    protected $guarded = array('id', 'parent_id', 'lft', 'rgt', 'depth');
    public $translatedAttributes = ['title','description', 'keywords', 'itemtype'];
    //protected $casts = ['isSeo' => 'string'];

    //получить рутовую ноду
    public function getRootNode() {
        return Type::root();
    }

    //получить ноду по id
    public function getNodeById($id) {
        return $this::find($id);
    }

    //перечень категорий в виде дерева
    public function getDescendantsTree(Type $node = null) {
        if($node) {
            return $node->getDescendants()->toHierarchy();
        }
        return [];
    }

    //удалить ноду
    public function destroyNode(Type $node) {
        $node->delete();
    }

    //сохранить изменения ноды
    public function postNode() {
        $data = Input::except('_token', 'fields', 'relate_with', 'parent');

        $this->setRelatewith($this->id, Input::get('relate_with'));

        $fields = Input::get('fields');
        $fields = str_replace("\r\n",';',$fields);
        $data['fields'] = $fields;

        $fields = Input::get('fields_aside');
        $fields = str_replace("\r\n",';',$fields);
        $data['fields_aside'] = $fields;

        //сменить родителя
        $parent = Input::get('parent');
        $this->makeChildOf($parent);

        if($parent != $this->parent->id) {
            //меняем родителя для элемента из main (есть баг, ирогда элемент менят родителя)
            $item_main = Main::where('type_id', $this->id)->first();
            $parent_main = Main::where('type_id', $parent)->first();
            if($item_main && $parent_main) {
                $item_main->makeChildOf($parent_main->id);
            }
            if($item_main && $parent == 1) {
                $item_main->makeChildOf(1);
            }
        }

        $this->update($data);
    }

    public function isRelatewithId($id) {
        $relate_with = unserialize($this['relate_with']);

        if(is_array($relate_with)) {
            if(in_array($id,$relate_with)) {
                return 1;
            }
        }
    }

    //добавить и удалить разрешенные связи между типами
    private function setRelatewith($id, $arr = []) {
        $root = $this->getRootNode();
        $types = $root->getDescendantsAndSelf();
        if(!is_array($arr)) $arr = [];

        foreach($types as $type) {
            if(in_array($type->id, $arr)) {
                $this->relativeAdd($type->id, $id);
                $this->relativeAdd($id, $type->id);
            }
            else {
                $this->relativeRemove($type->id, $id);
                $this->relativeRemove($id, $type->id);
            }
        }
    }

    //добавить связь
    private function relativeAdd($id, $id_relative) {
        $node = $this->getNodeById($id);
        $fromDatabase = unserialize($node['relate_with']);
        if(!is_array($fromDatabase)) $fromDatabase = [];
        array_push($fromDatabase, $id_relative);
        $fromDatabase = array_unique($fromDatabase);
        $node['relate_with'] = serialize($fromDatabase);
        $node->save();
    }

    //удалить связь
    private function relativeRemove($id, $id_relative) {
        $node = $this->getNodeById($id);
        $fromDatabase = unserialize($node['relate_with']);

        if(is_array($fromDatabase)) {
            if(($key = array_search($id_relative, $fromDatabase)) !== false) {
                unset($fromDatabase[$key]);
                $node['relate_with'] = serialize($fromDatabase);
                $node->save();
            }
        }
    }

    //фикс совместной работы baum и translatable
    public function save(array $options = array()) {
        $tempTranslations = $this->translations;
        if ($this->exists)
        {
            if (count($this->getDirty()) > 0)
            {
                // If $this->exists and dirty, parent::save() has to return true. If not,
                // an error has occurred. Therefore we shouldn't save the translations.
                if (parent::save($options))
                {
                    $this->setRelation('translations', $tempTranslations);
                    return $this->saveTranslations();
                }
                return false;
            }
            else
            {
                // If $this->exists and not dirty, parent::save() skips saving and returns
                // false. So we have to save the translations
                $this->setRelation('translations', $tempTranslations);
                return $this->saveTranslations();
            }
        }
        elseif (parent::save($options))
        {
            // We save the translations only if the instance is saved in the database.
            $this->setRelation('translations', $tempTranslations);
            return $this->saveTranslations();
        }
        return false;
    }

    //region RELATION
    public function main() {
        return $this->hasOne('App\Models\Main');
    }
    //endregion
}
