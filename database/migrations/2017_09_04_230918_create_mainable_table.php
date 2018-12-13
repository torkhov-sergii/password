<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMainableTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mainables', function(Blueprint $table) {
            $table->integer('main_id')->unsigned()->index();
            $table->integer('mainable_id')->unsigned()->nullable()->index();
            $table->string('mainable_type')->nullable()->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('mainables');
    }
}
