<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIngridientTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->unique();
            $table->timestamps();
        });

        Schema::create('ratings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->unique();;
            $table->timestamps();
        });

        Schema::create('ingridients', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->unique();
            $table->text('description')->nullable();
            $table->unsignedInteger('rating_id');
            $table->string('source');

            $table->foreign('rating_id')->references('id')->on('ratings');
            $table->timestamps();
        });

        Schema::create('category_ingridient', function (Blueprint $table) {
            $table->unsignedInteger('ingridient_id');
            $table->unsignedInteger('category_id');

            $table->primary(array('ingridient_id', 'category_id'));

            $table->foreign('ingridient_id')
                ->references('id')
                ->on('ingridients')
                ->onDelete('cascade');

            $table->foreign('category_id')
                ->references('id')
                ->on('categories')
                ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('category_ingridient', function (Blueprint $table) {
            $table->dropForeign(['ingridient_id']);
            $table->dropForeign(['category_id']);
        });

        Schema::table('ingridients', function (Blueprint $table) {
            $table->dropForeign(['rating_id']);
            $table->dropColumn(['rating_id']);
        });

        Schema::dropIfExists('ingridients');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('ratings');
        Schema::dropIfExists('ingridient_category');
    }
}
