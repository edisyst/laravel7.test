<?php

use Illuminate\Database\Seeder;

class PhotosTableSeeder extends Seeder
{


    public function run()
    {
/*
        //PRIMA SVUOTO LA TABELLA
        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=0');
        \App\Models\Photo::truncate();
*/
        //RICHIAMO factory()
//        $photos = factory(\App\Models\Photo::class, 10)->create();


        $albums = \App\Models\Album::get();
        foreach ($albums as $item){
            factory(\App\Models\Photo::class, 30)->create([
                'album_id' => $item->id
            ]);
        }
    }
}
