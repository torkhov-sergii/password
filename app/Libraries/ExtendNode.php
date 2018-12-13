<?php namespace App\Libraries;

use Baum\Node;

class ExtendNode extends Node {

    //фикс селекта вместе с join другой таблицы. например main+type=error из за одинаковых полей
    public function descendantsAndSelf() {
        return $this->newNestedSetQuery()
            ->where($this->getQualifiedLeftColumnName(), '>=', $this->getLeft())
            ->where($this->getQualifiedLeftColumnName(), '<', $this->getRight());
    }

    public function scopeWithoutNode($query, $node) {
        return $query->where($this->getTable() . '.' . $node->getKeyName(), '!=', $node->getKey());
    }

//    public function descendantsAndSelf() {
//        return $this->newNestedSetQuery()
//            ->where($this->getLeftColumnName(), '>=', $this->getLeft())
//            ->where($this->getLeftColumnName(), '<', $this->getRight())
//            ->query(['with'=>'','result'=>'']);
//    }

}