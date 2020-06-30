<?php

use Illuminate\Database\Seeder;
use \App\Models\Category;
use \App\Models\User;

class SeedAlbumCategoriesTable extends Seeder
{


    public function run()
    {
        $categories = ['nature', 'animals', 'cats', 'business', ]; //lorempixel.com

        foreach ($categories as $item) {
//            $categories = Category::inRandomOrder()->take(2)->pluck('id');
            Category::create([
                'category_name' => $item,
                'user_id' => User::inRandomOrder()->first()->id
            ]);
        }
    }
}

