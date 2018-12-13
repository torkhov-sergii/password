<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMainMainPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('main_main', function(Blueprint $table) {
            $table->integer('main_id1')->unsigned()->index();
            $table->foreign('main_id1')->references('id')->on('main')->onDelete('cascade');
            $table->integer('main_id2')->unsigned()->index();
            $table->foreign('main_id2')->references('id')->on('main')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('main_main');
    }
}
