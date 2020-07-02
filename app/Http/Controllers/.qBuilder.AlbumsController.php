<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Album;
use Illuminate\Support\Facades\DB;

class AlbumsController extends Controller
{

    //POSSO ANCHE PASSARGLI L'ID SULL'URL
    public function index(Request $request)
    {
/*
//        return Album::all();
        $sql = "SELECT * FROM albums";
        $where ='';

        //SE HA QUELLA CHIAVE, OVVERO $_GET['id']
        if($request->has('id')){
            //POSSO CASTARLO COSI' MI PROTEGGO DA SQL.INJ
            $where .= " WHERE id=" . (int)$request->get('id');
        }

        if($request->has('album_name')){
            //POSSO CASTARLO COSI' MI PROTEGGO DA SQL.INJ
            $where .= " AND album_name='" . $request->get('album_name') ."'";
        }

        //?id=2&album_name=Bella Hessel' OR '1'='1
        //"SELECT * FROM albums WHERE id=2 AND album_name='Bella Hessel' OR '1'='1'"
        $sql.=$where;
//        dd($sql);

        return DB::select($sql);    //RESTITUISCE UN ARRAY DI RECORD
*/

//        $sql = "SELECT * FROM albums WHERE 1=1";
        $queryBuilder = DB::table('albums')->orderBy('id', 'DESC');

        if($request->has('id')){
            $queryBuilder->where('id', '=', $request->input('id'));
        }
        if($request->has('album_name')){    //GLI FACCIO RICONOSCERE UNA PARTE DEL NOME
            $queryBuilder->where('album_name', 'LIKE', '%'.$request->input('album_name').'%');
        }

        $albums = $queryBuilder->get(); //get() RESTITUISCE UNA COLLECTION
        return view('albums.albums', [ 'albums' => $albums]);
/*
        $where =[];

        if($request->has('id')){
            $where['id'] = $request->get('id');
            $sql .= " AND id= :id";
        }

        if($request->has('album_name')){
            $where['album_name'] = $request->get('album_name');
            $sql .= " AND album_name= :album_name";
        }
        $sql .= " ORDER BY id DESC";

//        return DB::select($sql, array_values($where)); //SE USASSI ? COME PLACEHOLDER
        $albums = DB::select($sql, $where);
        return view('albums.albums', [ 'albums' => $albums]);
*/
    } // END function index



    public function delete($id)
    {
        //SELEZIONO TABELLA, FILTRO, INFINE delete()
        DB::table('albums')->where('id', $id)->delete();

        //        $sql = "DELETE FROM albums WHERE id = :id";
//        DB::delete($sql, ['id' => $id]);
        return redirect('/albums');
//        return redirect->back();
    } // END function delete


    public function show($id)
    {
        $sql = "SELECT * FROM albums WHERE id = :id";
        return DB::select($sql, ['id' => $id]);
    } // END function show



    public function edit($id)
    {
        $sql = "SELECT id,album_name,description FROM albums WHERE id = :id";
        $album = DB::select($sql, ['id' => $id]);
        return view('albums.editalbum')->with('album', $album[0]);//SOLO IL 1° ELEMENTO
    } // END function show



    public function store($id, Request $req)
    {
        $res = DB::table('albums')->where('id', $id)->update([
            'album_name'  => request()->input('name'),
            'description' => $req['description']  //POSSO USARE ENTRAMBI I MODI
        ]);
/*
//        dd(request()->all());
        $data = request()->only(['name','description']); //SERVONO SOLO QUESTI
        $data['id'] = $id; //QUESTO LO POSSO PRENDERE SOLO COSì
        $sql = "UPDATE albums SET album_name=:name, description=:description";
        $sql.= " WHERE id= :id";
        $res = DB::update($sql, $data);
*/
        $messaggio = $res ? 'Album nr. '.$id.' modificato' : 'Nessuna modifica fatta';

        //METTO UN VALORE CHE VARRA' PER UN SOLO REFRESH
        session()->flash('message', $messaggio);
        return redirect()->route('albums');

    } // END function store



    public function create()
    {
        return view('albums.createalbum');
    }

    public function save()
    {
        $res = DB::table('albums')->insert([
            'album_name'  => request()->input('name'),
            'description' => request()->input('description'),
            'user_id'     => 1
        ]);
/*
        $data = request()->only(['name', 'description']);
        $data['user_id'] = 1; //PER ORA LO METTO FISSO
        $sql = "INSERT INTO albums (album_name, description, user_id)";
        $sql.=" VALUES(:name, :description, :user_id)";
        $res = DB::insert($sql, $data);
*/
        $messaggio = $res ? 'Album '.request()->input('name').' inserito' : 'Nessun inserimento fatto';
        session()->flash('message', $messaggio);
        return redirect()->route('albums');

    }




}
