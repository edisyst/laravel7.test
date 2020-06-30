<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use \App\Models\Album;
use \App\Models\Photo;
use \App\Models\Category;
use \App\Models\AlbumsCategory;

class DatabaseSeeder extends Seeder
{

    public function run()
    {
        //PER FARE TRUNCATE DEVO PRIMA DISABILITARE LE FOREIGN KEY
        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=0');

        //POI SVUOTO LE TABELLE
        User::truncate();
        Album::truncate();
        Photo::truncate();
        Category::truncate();
        AlbumsCategory::truncate();

        //INFINE CHIAMO I SINGOLI SEED
        $this->call(UsersTableSeeder::class);
        $this->call(AlbumsTableSeeder::class);
        $this->call(PhotosTableSeeder::class);
        $this->call(SeedAlbumCategoriesTable::class); //DOVREI SPOSTARLA DI ORDINE IN TEORIA

    }
}
