<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fields', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('subject_id')->unsigned()->index();
            $table->string('subject_type')->nullable()->index();

            $table->string('value')->nullable()->default('');
            $table->string('value2')->nullable()->default('');
            $table->enum('type', ['', 'phone', 'email'])->index();
            $table->integer('param');
            $table->integer('isPublic')->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('fields');
    }
}
