<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlbumCategoriesTable extends Migration
{

    public function up()
    {
        //TABELLA CATEGORIES
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('category_name', 64)->unique();
            $table->integer('user_id')->unsigned()->index();
            $table->foreign('user_id')->on('users')->references('id');
            $table->timestamps();
            $table->softDeletes();
        });

        //TABELLA RELAZIONALE (TABLE PIVOT): NOME STANDARD DI LARAVEL
        Schema::create('album_category', function (Blueprint $table) {
            $table->id();
            $table->integer('album_id')->unsigned();
            $table->integer('category_id')->unsigned();
            //LO STESSO album_id CON LO STESSO category_id PUO' ESISTERE UNA SOLA VOLTA
            $table->unique(['album_id', 'category_id']);
            $table->timestamps();
        });
    }



    public function down()
    {
//        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('album_category');
    }
}
