<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

//$categories = ['nature', 'architecture', 'animals', 'tech', 'sepia', ]; //placeimg.com
$categories = ['nature', 'animals', 'cats', 'business', ]; //lorempixel.com

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

//$factory E' UNA VARIABILE GLOBALE
$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
    ];
});



//DOC: SU GOOGLE CERCA "Faker Fazinotto"
//$factory E' UNA VARIABILE GLOBALE
// \App\Models\Album::class DEVE ESSERE UN NOME UNIVOCO
$factory->define(\App\Models\Album::class, function (Faker $faker) use($categories) {
    return [
        'album_name' => $faker->name,
        'description' => $faker->text(128),

        //PRENDO UN UTENTE DA users RANDOM E GLI ASSOCIO L'ALBUM
        //NB: QUANDO CHIAMO UN METODO CON UN MODEL, DEVE ESSERE UN METODO STATICO
        'user_id' => User::inRandomOrder()->first()->id,
        'album_thumb' => $faker->imageUrl(120, 120, $faker->randomElement($categories)),
    ];
});



$factory->define(\App\Models\Photo::class, function (Faker $faker) use($categories) {
    return [
//        'album_id' => \App\Models\Album::inRandomOrder()->first()->id,
        'album_id' => 1,
        'name' => $faker->text(64),
        'description' => $faker->text(128),
        'img_path' => $faker->imageUrl(300, 400, $faker->randomElement($categories)),
    ];
});






