<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use function Sodium\crypto_box_publickey_from_secretkey;

//use App\Models\Album;

class Photo extends Model
{
    protected $fillable = ['album_name', 'img_path', 'description', 'user_id']; //SERVE SE USO create()

    public function album()
    {
//        return $this->belongsTo(Album::class,'album_id','id');
        return $this->belongsTo(Album::class);
    }



    public function getPathAttribute()
    {
        $url = $this->attributes['img_path'];  //DI DEFAULT E' QUESTA
        if(strstr($url, 'http') === false){
            $url = 'storage/'.$url;
        }
        return $url;
    }

    //ACCESSOR: X ACCEDERE ALLE PROPRIETA' PRIMA DI MODIFICARLE
    //UN ALTRO MODO PER ARRIVARE A UN ATTRIBUTO TRAMITE UN ACCESSOR
    //  SINTASSI:   get <Attributo> Attribute
    public function getImgPathAttribute($value)
    {
        if(strstr($value, 'http') === false){
            $value = 'storage/'.$value;
        }
        return $value;
    }


    //MUTATOR: X MODIFICARE LE PROPRIETA'. PRIMA DI INSERIRE IL VALORE, LUI MODIFICA IL NAME
    //INTERVIENE IN AUTOMATICO QUANDO ASSEGNO $photo->name
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = strtoupper($value);
        if(strstr($value, 'http') === false){
            $value = 'storage/'.$value;
        }
        return $value;
    }


}





