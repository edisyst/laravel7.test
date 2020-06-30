<?php


namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use App\Models\Photo;
use App\Models\Category;


class Album extends Model //CONVIENE AGGIUNGERE extends Model
{
//    protected $table = 'albums';   //SE NON MAPPASSE LA TABELLA DI NOME albums
//    protected $primaryKey = 'id';  //GIà COSì DI DEFAULT
    protected $fillable = ['album_name', 'description', 'user_id']; //SERVE SE USO create()

    //METODO getPathAttribute CHE POSSO RICHIAMARE COME ATTRIBUTO path
    public function getPathAttribute($key)
    {
        $url = $this->album_thumb;  //DI DEFAULT E' QUESTA
        if(strstr($this->album_thumb, 'http') === false){
            $url = 'storage/'.$this->album_thumb;
        }
        return $url;
    }



/********************************
 * RELAZIONI CON LE ALTRE TABLE *
 ********************************/

    //QUI DICHIARO LA RELAZIONE TRA Album E Photo
    public function photos()
    {
        //DEFAULT: COME F.KEY SI ASPETTA NELLA CLASSA FIGLIA nomeTabellaMadre_primaryKeyMadre
        //DEFAULT: COME P.KEY SI ASPETTA NELLA CLASSA FIGLIA id
        //QUINDI QUEI 2 PARAMETRI SONO SOTTINTESI IN QUESTO ESEMPIO
        return $this->hasMany(Photo::class, 'album_id','id');

    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // IN TEORIA LA NAMING CONVENTION SAREBBE STATA album_album_category
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'album_category', 'album_id', 'category_id')
            ->withTimestamps(); //IN AUTOMATICO POPOLA I CAMPI created_at E updated_at
    }


}