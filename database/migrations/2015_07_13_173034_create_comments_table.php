<?php
/** actuallymab | 12.06.2016 - 02:00 */

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('parent_id')->nullable()->index();
            $table->integer('lft')->nullable()->index();
            $table->integer('rgt')->nullable()->index();
            $table->integer('depth')->nullable()->index();

            $table->string('commentable_id')->nullable()->index();
            $table->string('commentable_type')->nullable()->index();
            $table->index(['commentable_id', 'commentable_type'])->index();
            $table->string('commented_id')->nullable()->index();
            $table->string('commented_type')->nullable();
            $table->index(['commented_id', 'commented_type']);
            $table->longText('body')->nullable();
            $table->string('name')->default('');
            $table->string('email')->default('');
            $table->string('website')->default('');
            $table->boolean('approved')->default(true);
            $table->double('rate', 15, 8)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('comments');
    }
}
