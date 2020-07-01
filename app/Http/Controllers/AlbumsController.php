<?php

namespace App\Http\Controllers;

use App\Http\Requests\AlbumCreateRequest;
use App\Models\Category;
use App\Models\Photo;
use \Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use App\Models\Album;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\AlbumUpdateRequest;


class AlbumsController extends Controller
{
    public function __construct()
    {
        //PROTEGGERE TUTTE LE ROTTE CHE CHIAMANO TUTTI I METODI DI AlbumsController
//        $this->middleware('auth');
//        $this->middleware('auth')->only(['create', 'edit']);
//        $this->middleware('auth')->except(['index']);
    }


    //POSSO ANCHE PASSARGLI L'ID SULL'URL
    public function index(Request $request)
    {
                        //DB::table('albums')->
        $queryBuilder = Album::orderBy('id', 'DESC')
            ->withCount('photos') //RICHIAMO IL METODO photos
            ->with('categories');  //EAGER LOADING: PER NON FARE N QUERY
//        dd(Auth::user()->id);
//        dd($request->user()->id);
        $queryBuilder->where('user_id', Auth::user()->id);


        if($request->has('id')){
            $queryBuilder->where('id', '=', $request->input('id'));
        }
        if($request->has('album_name')){    //GLI FACCIO RICONOSCERE UNA PARTE DEL NOME
            $queryBuilder->where('album_name', 'LIKE', '%'.$request->input('album_name').'%');
        }

        $albums = $queryBuilder->get(); //get() RESTITUISCE UNA COLLECTION
//        dd($albums);
        return view('albums.albums', [ 'albums' => $albums]);
    } // END index



    //GLI PASSO $id NUMERICO: LUI IN AUTOMATICO CAPISCE CHE è PR.KEY
    //DELLA TABLE DEL MODEL Album NONCHè {$id} DELLA ROTTA
    public function delete(Album $album)
    {
//        $res = Album::where('id', $album)->delete();
//        $res = Album::find($album)->delete();

        $thumbnail = $album->album_thumb;
        $disk = config('filesystems.default'); // config/filesystems.php, VARIABILE default

        if($res = $album->delete()){
            if ($thumbnail && Storage::disk($disk)->has($thumbnail)){
                Storage::disk('public')->delete($thumbnail);
            }
            //OVUNQUE LO METTA, NON PARTE IL CAZZO DI MESSAGGIO, SI VEDE SOLO DOPO CHE AGGIORNO LA PAGINA
            $messaggio = $res ? 'Album nr. '.$album->id.' eliminato' : 'Non ho eliminato';
            session()->flash('message', $messaggio);
        }
        if(request()->ajax()) {
            return ''.$res; //PER RENDERLA UNA STRINGA
        } else {
            return redirect()->route('albums');
        }

    } // END delete


    public function show($id)
    {
        $sql = "SELECT * FROM albums WHERE id = :id";
        return DB::select($sql, ['id' => $id]);
    }



    public function edit($id)
    {
        $album = Album::find($id);  //SELECT *
/*
        //  dd($album->user);   //POSSO FARLO GRAZIE AL belongsTo(), LO TROVO IN attributes
        if($album->user->id !== Auth::user()->id){
            abort(401, 'non autorizzato'); //views/errors/401.blade.php
        }
*/
//        if(Gate::denies('manage-album', $album)){
//            abort(401, 'non autorizzato'); //views/errors/401.blade.php
//        }

//        Auth::user()->can('update', $album);    //DA VERIFICARE
        $this->authorize($album);

        $categories = Category::get();
        $selectedCategories = $album->categories->pluck('id')->toArray(); //COSI' NON HO N ISTANZE PER N CATEGORIE CON TUTTI LGI ATTRIBUTI
//        dd($selectedCategories);

        return view('albums.editalbum')->with([
            'album' => $album,
            'categories' => $categories,
            'selectedCategories' => $selectedCategories,
            ]);
    }



//  public function store($id, Request $req)
    public function store($id, AlbumUpdateRequest $req)
    {
/*
        $res = Album::where('id', $id)->update([
            'album_name'  => request()->input('name'),
            'description' => $req['description']  //POSSO USARE ENTRAMBI I MODI
        ]);
*/
        $album = Album::find($id);

//        if(Gate::denies('manage-album', $album)){
//            abort(401, 'non autorizzato'); //views/errors/401.blade.php
//        }

        $this->authorize('update', $album); //'update' PUO' ESSERE SOTTINTESO

        $album->album_name  = request()->input('name');
        $album->description = $req->input('description');
        $album->user_id = $req->user()->id;
        $this->processFile($id, $req, $album);

        $res = $album->save();  //ELOQUENT SI ACCORGE CHE HO GIà id, NON CREA UN NUOVO RECORD

        $album->categories()->sync($req->categories); //ARRAY categories[] PRESO DAL FORM

        $messaggio = $res ? 'Album nr. '.request()->input('name').' aggiornato' : 'Nessuna modifica fatta';
        session()->flash('message', $messaggio);
        return redirect()->route('albums');

    } // END store



    public function create()
    {
        //DEVO PASSARE UNA VARIABILE $album FINTA
        $album = new Album();

        $categories = Category::get();

        return view('albums.createalbum', [
            'album'      => $album,
            'categories' => $categories,
        ]);
    }


    public function save(AlbumCreateRequest $request) //AL POSTO DI Request
    {
        $album = new Album();
        $album->album_name  = request()->input('name');
        $album->description = $request->input('description');
        $album->user_id = $request->user()->id;

//        $this->processFile($id, $req, $album);
        $this->processFile($album->id, $request, $album);

        $res = $album->save(); //SALVO LA NUOVA THUMBNAIL

        if($res) {
            event(new \App\Events\NewAlbumCreated($album)); //SCATENO L'EVENTO DI INVIO MAIL-NEW-ALBUM
            
            if($request->has('categories')){                    //attach() AGGIUNGE LE CATEGORIE
                $album->categories()->attach($request->categories); //$request->input('categories')
            }

            $messaggio = $res ? 'Album ' . $request->input('name') . ' inserito' : 'Nessun inserimento fatto';
            session()->flash('message', $messaggio);

            return redirect()->route('albums');
        }
    }


    //&$album : E' UN RIFERIMENTO, UN PUNTATORE
    public function processFile($id, Request $req, &$album): bool   //SOLO IN PHP7 POSSO SPECIFICARE IL TYPE DI RITORNO
    {
        if (!$req->hasFile('album_thumb')) {
            return false;
        }

        $file = $req->file('album_thumb');
        if($file->isValid()){
            $filename = $id . '.' . $file->extension(); // immagine.png
            $file->storeAs(env('ALBUM_THUMB_DIR'), $filename);

            $album->album_thumb = env('ALBUM_THUMB_DIR') . '/' . $filename;
            return true;
        }
    }



    public function getImages($id)
    {
        $album = Album::find($id);
        $images = Photo::where('album_id', $id)->paginate(env('IMG_PER_PAGE'));

//        $images = Photo::where(['album_id' => $album->id])->get();
//        $images = Photo::where('album_id', $album->id)->latest()->paginate(env('IMG_PER_PAGE'));
//        return $images;
        return view('images.albumimages', compact(['album', 'images']));


    }



}
