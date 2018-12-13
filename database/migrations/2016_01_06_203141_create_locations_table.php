<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locations', function(Blueprint $table)
        {
            $table->increments('id');
            $table->unsignedInteger('locations_id')->index()->nullable();
            $table->string('locations_type')->nullable()->default('');

            $table->string('country_slug')->nullable()->default('')->index();
            $table->string('city_slug')->nullable()->default('')->index();

            $table->string('name')->nullable()->default('');
            $table->string('location')->nullable()->default('');
            $table->string('city')->nullable()->default('');
            $table->string('country')->nullable()->default('');
            $table->string('postal_code')->nullable()->default('');
            $table->string('lat', 10)->nullable()->default('');
            $table->string('lng', 10)->nullable()->default('');
            $table->integer('manually')->default(0);
            //$table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            //$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('locations');
    }
}
