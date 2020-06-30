<?php

use Illuminate\Database\Seeder;
use App\Models\Album;
use App\Models\Category;

class AlbumsTableSeeder extends Seeder
{


    public function run()
    {
/*
        //PRIMA SVUOTO LA TABELLA
        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Album::truncate();
*/

        //RICHIAMO factory()
        $albums = factory(Album::class, 10)
            ->create()
            ->each(function ($album){
                $categories = Category::inRandomOrder()->take(2)->pluck('id');
                $categories->each(function ($cat_id) use($album){
                    Category::create([
                        'album_id'    => $album->id,
                        'category_id' => $cat_id
                    ]);
                });
            });

    }
}
