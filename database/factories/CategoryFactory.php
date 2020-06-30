<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Category;
use Faker\Generator as Faker;

//NEI SEEDER POTRO' CHIAMARE DIRETTAMENTE QUESTA FACTORY
$factory->define(Category::class, function (Faker $faker) {
    return [
        //
        'category_name' => $faker->text(16),
//        'user_id' => User::inRandomOrder()->first()->id,
        'user_id' => 1,
//        'user_id' => factory(\App\Models\User::class, 1)->create()->id,

    ];
});
