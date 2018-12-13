<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMainTable extends Migration {

    public function up()
    {
        Schema::create('main', function (Blueprint $table) {
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

            $table->integer('type_id')->nullable()->index();
            $table->integer('user_id')->nullable()->index();

            $table->string('slug')->default('')->index();

            $table->boolean('hide')->default(0)->index();
            $table->integer('sort')->nullable()->index();

            $table->timestamps();
        });
    }

  public function down() {
    Schema::drop('main');
  }
}
