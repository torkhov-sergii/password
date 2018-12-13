<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTypeTranslations extends Migration {

    public function up()
    {
        Schema::create('type_translations', function (Blueprint $table) {

            $table->increments('id');
            $table->integer('type_id')->unsigned();
            $table->string('locale')->nullable()->index();

            $table->string('title')->nullable()->default('[name]');
            $table->string('description')->nullable()->default('[global_description]');
            $table->string('keywords')->nullable()->default('[global_keywords]');
            $table->string('itemtype')->nullable()->default('Article');

            $table->unique(['id','locale']);
            $table->foreign('id')->references('id')->on('type')->onDelete('cascade');
        });
    }

    public function down() {
        Schema::drop('type_translations');
    }
}
