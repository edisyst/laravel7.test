<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\DB;


//LE ROTTE DI mapAdminRoutes() HANNO TUTTE IL PREFISSO /admin

//Route::get('/', function (){
//    dd(\Illuminate\Support\Facades\Auth::user()->isAdmin());
//});


//Route::view('/','templates/admin')->name('admin');


Route::resource('users', 'Admin\AdminUsersController',
    [
        'names' => ['index' => 'user-list']     //OVERRIDE DEI NAME DELLE ROTTE GENERATE DA Route::resource
    ]
);
Route::get('getUsers',  'Admin\AdminUsersController@getUsers')
    ->name('admin.getUsers');

Route::patch('restore/{id}',  'Admin\AdminUsersController@restore')
    ->name('users.restore');
Route::view('/','templates/admin')->name('admin');

Route::get('/dashboard',function (){
    return "Admin Dashbaord";
});