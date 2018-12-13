<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTypeTable extends Migration {

    public function up() {
        Schema::create('type', function(Blueprint $table) {
            // These columns are needed for Baum's Nested Set implementation to work.
            // Column names may be changed, but they *must* all exist and be modified
            // in the model.
            // Take a look at the model scaffold comments for details.
            // We add indexes on parent_id, lft, rgt columns by default.
            $table->increments('id');
            $table->integer('parent_id')->nullable()->index();
            $table->integer('lft')->nullable()->index();
            $table->integer('rgt')->nullable()->index();
            $table->integer('depth')->nullable()->index();

            // Add needed columns here (f.ex: name, slug, path, etc.)
            $table->string('name')->nullable()->default('');
            $table->string('route')->nullable()->default('');
            $table->string('icon')->nullable()->default('');
            $table->boolean('isAdd')->default(1);
            $table->boolean('isEdit')->default(1);
            $table->boolean('isDel')->default(1);
            $table->boolean('isSeo')->default(0);
            $table->boolean('isSort')->default(0);
            $table->boolean('isSub')->default(0);
            $table->boolean('isShowInMenu')->default(0);

            $table->binary('fields')->nullable();
            $table->binary('relate_with')->nullable();

            $table->timestamps();
        });
    }

    public function down() {
        Schema::drop('type');
    }
}
