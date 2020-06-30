<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;

use Illuminate\Support\Facades\DB;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});
//
//E' UN MODO PIU' VELOCE PER RICHIAMARE UNA VIEW
//Route::view('/' , 'welcome');
Route::view('/' , 'welcome' ,
    [
        'name' => Request::input('name'),
//        'message' => 'Lorem ipsum Edoardo Testagrossa'
    ]);




//TEST MODEL ALBUM
/*
Route::get('/albums' , 'AlbumsController@index'
    function(){
        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=0');
        // use \App\Models\Album;  //SE LO RICHIAMO SOPRA, QUI BASTA Album::
        return \App\Models\Album::all();  //METODO STATICO CON ::
    }
)->name('albums'); //E' UTILE DARLE UN name COSI' SE CAMBIA L'URL LA ROTTA LA IDENTIFICO COL name
*/



//REDIRECT DOPO IL LOGIN ALLA PAGINE albums
Route::get('/home' , 'AlbumsController@index')->name('albums');



Route::group([
    'middleware' => 'auth'
    ],
    function(){
        //QUESTA LA PROTEGGO NEL Route::group()
//        Route::get('/albums' , 'AlbumsController@index')
//            ->name('albums');
});

//QUESTA LA PROTEGGO NEL Route::group()
        Route::get('/albums' , 'AlbumsController@index')
            ->name('albums');
//            ->middleware('auth');

//QUESTA LA PROTEGGO COL MIDDLEWARE
Route::get('/albums/create' , 'AlbumsController@create')
    ->name('album.create')
    ->middleware('auth');


//VIA DELETE NON ACCEDO ALLA RISORSA, VIA GET Sì
Route::get('/albums/{id}' , 'AlbumsController@show')
    ->where('id', '(0-9)+');      //ALTRIMENTI ACCETTA ANCHE id NULLO
//    ->middleware('can:view, id');             //COMPLICATO, NON CREDO DI USARLO
Route::get('/albums/{id}/delete' , 'AlbumsController@delete')
    ->where('id', '[0-9]+');
Route::get('/albums/{id}/edit' , 'AlbumsController@edit');

//Route::post('/albums/{id}/store' , 'AlbumsController@store');
Route::patch('/albums/{id}/store' , 'AlbumsController@store');
Route::post('/albums' , 'AlbumsController@save')
    ->name('album.save');

Route::get('/albums/{id}/images' , 'AlbumsController@getImages')
    ->name('album.getimages')
    ->where('album','(0-9)+');




//TEST MODEL PHOTO
Route::get('/photos' , function(){
    return \App\Models\Photo::all();
});


Route::get('/users' , function() {   return \App\Models\User::all();   });

Route::get('/usersnoalbum' , function() {
    /*
        SELECT u.id, name, album_name FROM users AS u
        LEFT JOIN albums AS a ON u.id = a.user_id
        WHERE album_name IS NULL
     */
    $usersnoalbum = DB::table('users AS u')
//        ->whereRaw('NOT EXISTS (SELECT user_id FROM albums WHERE user_id=u.id)')  //QUERY RAW
        ->leftJoin('albums AS a', 'u.id', '=', 'a.user_id')
        ->select('u.id', 'email', 'name', 'album_name')
        ->whereNull('album_name')
//        ->whereRaw('album_name IS NULL')  //QUERY RAW
        ->get();
    return $usersnoalbum;
});




// ------images-------- //
Route::resource('photos', 'PhotosController'); //URL: /photos/edit /photos/delete



Auth::routes();  //LA AGGIUNGE COME INSTALLO auth

//Route::get('/home', 'HomeController@index')->name('home');
