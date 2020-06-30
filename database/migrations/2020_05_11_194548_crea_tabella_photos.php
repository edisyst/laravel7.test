<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreaTabellaPhotos extends Migration
{

//NON MI FUNZIONANO LE FOREIGN KEY, NON RIESCO A METTERLE SU PHPMYADMIN
    public function up()
    {
        // NOME_TABELLA, COLONNE_TABELLA
        Schema::create('photos', function (Blueprint $table) {
//            $table->id('id');
            $table->increments('id');
            $table->string('name', 128);
            $table->text('description');
            $table->integer('album_id')->unsigned();
            $table->string('img_path', 128);
            $table->softDeletes();
            $table->timestamps();               //NON CAPISCO PERCHE "ON DELETE CASCADE" IN QUESTO CASO
            $table->foreign('album_id')->on('albums')->references('id')->onDelete('cascade');
        });
    }



    public function down()
    {
        Schema::dropIfExists('photos');
    }
}
