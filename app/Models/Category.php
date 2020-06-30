<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Models\User;

class Category extends Model
{
    protected $table = 'categories';   //DI DEFAULT CERCHEREBBE 'categories'
    protected $fillable = ['category_name'];



    // CREO LA CORRISPONDENTE RELAZIONE CON Album: INVERTO GLI ULTIMI DUE INPUT
    public function albums()
    {
        return $this->belongsToMany(Album::class, 'album_category', 'category_id', 'album_id')
            ->withTimestamps(); //IN AUTOMATICO POPOLA I CAMPI created_at E updated_at
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }



    //getCategoriesByUserId -> CON scope IO GLI INIETTO IL Q.BUILDER COME PRIMO PARAMETRO
    //scope:IN AUTOMATICO GLI PASSO IL Q.BUILDER
    public function scopeGetCategoriesByUserId(Builder $queryBuilder, User $user)
    {
        $queryBuilder->where('user_id', $user->id)->withCount('albums')->latest();
        return $queryBuilder;
    }

}
