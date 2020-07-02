<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModificaAlbumsAlbumName extends Migration
{


    //MODIFICO LA STRUTTURA DELLA TABELLA: CAMBIO LA DIMENSIONE DELLA COLONNA
    public function up()
    {
        Schema::table('albums', function (Blueprint $table) {
            //
            //ALTER TABLE albums CHANGE album_name VARCHAR(200)
            $table->string('album_name', 200)->change();
        });
    }


    public function down()
    {
        Schema::table('albums', function (Blueprint $table) {
            //
            $table->string('album_name', 128)->change();
        });
    }
}
