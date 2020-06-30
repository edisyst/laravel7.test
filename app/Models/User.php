<?php

namespace App\Models;

use App\Models\Album;
use App\Models\Category;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class User extends Authenticatable
//CLASSE User PER LA TABELLA users
{
    use Notifiable;
    use SoftDeletes;

    //LA TABELLA DEVE MAPPARE LA CLASSE: REGOLA SUI NOMI
//    protected $table = 'nome_tabella'; //CASO MAI AVESSE UN NOME STRANO

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role'
    ];


    //PER ORA USO IL FORMATO DI DEFAULT
//    protected $dateFormat = 'd-m-Y H:i';


    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function albums()
    {
        return $this->hasMany(Album::class);
    }


    public function albumCategories()
    {
        return $this->hasMany(Category::class);
    }


    //ACCESSOR
    //LO RICHIAMO CON {{$album->user->fullName}}
    public function getFullNameAttribute()
    {
        return $this->name;
    }


    public function isAdmin()
    {
        return $this->role === 'admin';
    }




}
