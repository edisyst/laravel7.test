<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreaTabellaAlbums extends Migration
{


//NON MI FUNZIONANO LE FOREIGN KEY, NON RIESCO A METTERLE SU PHPMYADMIN
    public function up()
    {
        Schema::create('albums', function (Blueprint $table) {
//            $table->id('id');      //UNSIGNED AUTOINCREMENT PRIMARY KEY
            $table->increments('id');
            $table->string('album_name', 128)->unique();
            $table->string('album_thumb', 128); //VARCHAR(128)
            $table->text('description');
            $table->integer('user_id')->unsigned();
            //INDICO A COSA SI RIFERISCE LA F.K. SULLA TABELLA users E COSA FARE IN CASO DI
            $table->foreign('user_id')->on('users')->references('id')
                ->onDelete('cascade')->onUpdate('cascade'); //CASCADE=FAI LA STESSA AZIONE
            $table->softDeletes();
            $table->timestamps();   //COLONNE created_at E deleted_at
        });
    }


    public function down()
    {
        Schema::dropIfExists('albums');
    }
}
