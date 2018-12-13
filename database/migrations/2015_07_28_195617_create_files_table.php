<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilesTable extends Migration
{
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('subject_id')->index();
            $table->string('subject_type')->default('')->index();

            $table->string('file_type')->default('')->index()->nullable();
            $table->string('file_file_name')->nullable();
            $table->string('file_file_name_original')->nullable();
            $table->integer('file_file_size')->nullable();
            $table->string('file_content_type')->nullable();
            $table->timestamp('file_updated_at')->nullable();

            $table->timestamps();
        });

    }

    public function down()
    {
        Schema::drop('files');
    }
}
