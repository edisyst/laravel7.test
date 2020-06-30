<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PhotosController extends Controller
{

                              //   exists:table,column
    protected $rules =[
        'album_id'    => 'required|numeric|exists:albums,id',
        'name'        => 'required|unique:photos,name',
        'description' => 'required',
        'img_path'    => 'required|image',
    ];

    //  'campo.regola'
    protected $errorMessages =[
        'album_id.required' => 'Il campo Album deve essere valorizzato',
        'name.required'     => 'Inserire un Nome',
    ];



    public function __construct()
    {
        //PROTEGGERE TUTTE LE ROTTE CHE CHIAMANO TUTTI I METODI DI AlbumsController
        $this->middleware('auth');
//        $this->middleware('auth')->only(['create', 'edit']);
//        $this->middleware('auth')->except(['index']);

        //SICCOME PhotosController E' UN RESOURCE_CONTROLLER
//        $this->authorizeResource(Photo::class); //VIENE GESTITO OGNI METODO
    }



    public function index()
    {
        return Photo::get();
    }



    public function create(Request $req)
    {
        $id = $req->has('album_id') ? $req->input('album_id') : null;
        $album = Album::firstOrNew(['id' => $id]);

        $photo = new Photo();
        $albums = $this->getAlbums();
        return view('images.editimage', compact('album','photo', 'albums'));
    }



    public function store(Request $request)
    {
//        dd($request->only('name', 'album_id'));
        $this->validate($request, $this->rules, $this->errorMessages); //SE FALLISCE, TUTTO IL RESTO NON VIENE FATTO
//        $request->validate($this->rules, $this->errorMessages);     //UN ALTRO MODO PER SCRIVERLO
        //IL 2° RESTITUISCE UN ARRAY DEI DATI VALIDATI,

        $photo = new Photo();
        $photo->name = $request->input('name');
        $photo->description = $request->input('description');
        $photo->album_id = $request->input('album_id');

        $this->processFile($photo);
        $photo->save();
        return redirect(route('album.getimages', $photo->album_id));
    }



    public function show(Photo $photo) //DEVE AVERE LO STESSO NOME DELLA ROTTA CON {photo}
    {
        return $photo;
    }



    public function edit(Photo $photo)
    {
        //SENZA BINDING PARAM.INPUT (TYPE HINTING) FACCIO QUESTO
//        $photo = Photo::with('album')->find($photo);
        $albums = $this->getAlbums();
        $album = $photo->album();
//        dd($albums);
        return view('images.editimage',compact(['albums','photo', 'album']));
    }



    public function update(Request $request, Photo $photo)
    {
        $this->validate($request, $this->rules);

//        dd(request()->only(['name', 'description', '_method']));

        $this->processFile($photo);
        $photo->album_id = $request->album_id;
        $photo->name = $request->input('name');
        $photo->description = $request->input('description');
        $res = $photo->save();

        $messaggio = $res ? 'Foto '.request()->input('name').' modificata' : 'Nessun inserimento';
        session()->flash('message', $messaggio);
        return redirect()->route('album.getimages', $photo->album_id);
    }



    public function destroy(Photo $photo)
    {
        $res = $photo->delete();
        if($res){
            $this->deleteFile($photo);
        }
        return $res;

//        Photo::findOrFail($photo)->destroy(); //QUESTO  A ME NON FUNGE, FORSE E' QUESTO CHE CREA PROBLEMI ANCHE IN DELETE ALBUM
//        return Photo::destroy($photo);

    }


    public function processFile(Photo $photo, Request $req=null)   //SOLO IN PHP7 POSSO SPECIFICARE IL TYPE DI RITORNO
    {
        if (!$req) {
            $req = request();
        }

        if (!$req->hasFile('img_path')) {
            return false;
        }

        $file = $req->file('img_path');
        if(!$file->isValid()) {
            return false;
        }

        //SOSTITUISCO OGNI CARATTERE CHE NON SIA LETTERA O NUMERO CON UNDERSCORE
        $imgName = preg_replace('@[a-z0-9]i@','_', $photo->name);

        $filename = $photo->id . '.' . $file->extension(); // immagine.png
        $file->storeAs(env('IMG_DIR') .'/'. $photo->album_id, $filename);
        $photo->img_path =  env('IMG_DIR') .'/'. $photo->album_id .'/'. $filename;
        return true;
    }


    public function deleteFile(Photo $photo)
    {
        $disk = config('filesystem.default');
        if ($photo->img_path && Storage::disk($disk)->has($photo->img_path)){
            return Storage::disk($disk)->delete($photo->img_path);
        }
        return false;
    }


    public function getAlbums()
    {
        return Album::orderBy('album_name')
            ->where('user_id', Auth::user()->id)
            ->get();
    }


}
