<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMainTranslations extends Migration {

    public function up()
    {
        Schema::create('main_translations', function (Blueprint $table) {

            $table->increments('trans_id');
            $table->integer('main_id')->unsigned();
            $table->string('locale')->default('')->index();

            $table->string('name')->nullable()->default('');
            $table->text('text')->nullable();

            $table->string('title')->nullable()->default('');
            $table->string('description')->nullable()->default('');
            $table->string('keywords')->nullable()->default('');

            $table->longText('text1')->nullable();
            $table->longText('text2')->nullable();
            $table->longText('text3')->nullable();

            $table->string('string1')->nullable()->default('');
            $table->string('string2')->nullable()->default('');
            $table->string('string3')->nullable()->default('');
            $table->string('string4')->nullable()->default('');
            $table->string('string5')->nullable()->default('');

            $table->boolean('bool1')->nullable()->default(0);
            $table->boolean('bool2')->nullable()->default(0);
            $table->boolean('bool3')->nullable()->default(0);
            $table->boolean('bool4')->nullable()->default(0);
            $table->boolean('bool5')->nullable()->default(0);

            $table->string('select1')->nullable()->default('');
            $table->string('select2')->nullable()->default('');

            $table->dateTime('date')->nullable();
            $table->dateTime('date2')->nullable();

            $table->text('seo_meta_tags')->nullable();

            $table->unique(['main_id','locale']);
            $table->foreign('main_id')->references('id')->on('main')->onDelete('cascade');
        });
    }

    public function down() {
        Schema::drop('main_translations');
    }
}
