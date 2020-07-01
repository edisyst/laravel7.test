<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

use App\Mail\TestEmail;
use Illuminate\Support\Facades\Auth;
use App\Mail\TestMd;

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
/*
Route::view('/' , 'welcome' ,
    [
        'name' => Request::input('name'),
//        'message' => 'Lorem ipsum Edoardo Testagrossa'
    ]);
*/





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





Route::group([
    'middleware' => 'auth',
    'prefix' => 'dashboard'   //PREFISSO RISPOETTO ALLA URL PRINCIPALE
    ],
    function () {
        Route::get('/', 'AlbumsController@index')
            ->name('albums');
        // ->middleware('auth');
        //   Route::get('/home','AlbumsController@index')->name('albums');
        Route::get('/albums/create', 'AlbumsController@create')
            ->name('album.create');
        Route::get('/albums', 'AlbumsController@index')
            ->name('albums');

        Route::get('/albums/{album}', 'AlbumsController@show')
            ->where('id', '[0-9]+')//ALTRIMENTI ACCETTA ANCHE id NULLO
        ->middleware('can:view,album');

        Route::get('/albums/{id}/edit', 'AlbumsController@edit')
            ->where('id', '[0-9]+')
            ->name('album.edit');
        Route::delete('/albums/{album}/delete', 'AlbumsController@delete') //A ME PROPRIO NON FUNZIONA Route::delete
            ->name('album.delete')
            ->where('album', '[0-9]+');

        //Route::post('/albums/{id}','AlbumsController@store');
        Route::patch('/albums/{id}', 'AlbumsController@store')
            ->name('album.store');
        Route::post('/albums', 'AlbumsController@save')
            ->name('album.save');

        Route::get('/albums/{album}/images', 'AlbumsController@getImages')
            ->name('album.getimages')
            ->where('album', '[0-9]+');

        //TEST MODEL PHOTO
        Route::get('photos', function () {
            return Photo::all();
        });



//    Route::get('/users' , function() {   return \App\Models\User::all();   });

        Route::get('/usersnoalbum', function () {
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
        //E' UNA RISORSA QUINDI LE ROTTE PREDEFINITE POSSONO ESSERE RICHIAMATE
        Route::resource('photos', 'PhotosController'); //URL: /photos/edit /photos/delete



        //ROTTA DI PROVA CATEGORIE: E' UNA RISORSA QUINDI LE ROTTE PREDEFINITE POSSONO ESSERE RICHIAMATE
        Route::resource('categories', 'CategoryController');


    });


//GALLERY: SEZIONE PUBBLICA, SENZA LOGIN
Route::group([
    'prefix' => 'gallery'   //PREFISSO RISPOETTO ALLA URL PRINCIPALE
],
    function () {
        Route::get('/', 'GalleryController@index')->name('gallery.albums');
        Route::get('albums', 'GalleryController@index')->name('gallery.albums');
        Route::get('album/{album}/images', 'GalleryController@showAlbumImages')
            ->name('gallery.album.images');

        Route::get('albums/category/{category}', 'GalleryController@showAlbumByCategory')
            ->name('gallery.album.category');

    });

Auth::routes();  //LA AGGIUNGE COME INSTALLO auth





//ROTTA HOMEOPAGE
Route::get('/', 'GalleryController@index');
Route::redirect('home', '/');
Route::view('about','pages/about');



//REDIRECT DOPO IL LOGIN ALLA PAGINE albums
Route::get('/home' , 'AlbumsController@index')->name('albums');





//Route::view('testemail', 'mails.testemail', ['username' => 'Gigig']);
Route::get('testemail', function (){
//    Mail::send(new TestEmail(Auth::user())); //CON L'UTENTE LOGGATO

    $user = \App\Models\User::get()->first();
//    Mail::send(new TestEmail($user)); //ALL'UTENTE SELEZIONATO

    Mail::to('editestar@gmail.com')
        ->send(new TestMd($user)); //ALL'UTENTE SELEZIONATO
});




Route::get('testevent', function (){
    $album = \App\Models\Album::first();
    //METODO GLOBALE, E' UN HELPER
    event(new \App\Events\NewAlbumCreated($album)); //DOPO AVERLO TESTATO, LO METTO SU AlbumController
});



