<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImagesTable extends Migration
{
    public function up()
    {

        Schema::create('images', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('subject_id')->index();
            $table->string('subject_type')->default('')->index();
            $table->boolean('isPreview')->default(0)->index();

            $table->string('image_type')->default('')->index()->nullable();
            $table->string('image_file_name')->nullable();
            $table->integer('image_file_size')->nullable();
            $table->string('image_content_type')->nullable();
            $table->timestamp('image_updated_at')->nullable();

            $table->string('image_alt_ru')->nullable();
            $table->string('image_alt_ua')->nullable();
            $table->string('image_alt_en')->nullable();

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('images');
    }
}
