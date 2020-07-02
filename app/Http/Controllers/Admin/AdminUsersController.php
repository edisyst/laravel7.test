<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\UserFormRequest;


class AdminUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::orderBy('name')->get();
//        return view('admin/users', compact('users')); //NORMALMENTE USEREI compact PER PASSARE DATI ALLA VIEW
        return view('admin/users'); //CON DataTables MI SERVE LA VIEW E BASTA
    }


    private function getUserButtons(User $user)
    {
        $id = $user->id;
        // href="'.route('users.edit',['user'=>$id]).'"     LO METTO A TUTTI
        //MA SOLO users.edit E' CHIAMAVO VIA GET, AGLI ALTRI 2 IL METODO LO PASSO VIA AJAX
        $buttonEdit = '<a href="'.route('users.edit',['user'=>$id]).'" id="edit-'.$id.'" class="btn btn-primary" title="Edit"><i class="fa fa-pencil-alt"></i></a>';

        if($user->deleted_at){
            $deleteRoute = route('users.restore',['id'=>$id]);
            $deleteIcon = '<i class="fas fa-recycle"></i>';
            $btnId = 'restore-'.$id;
            $btnClass = 'btn-info';
        } else {
            $deleteRoute = route('users.destroy',['user'=>$id]);
            $deleteIcon = '<i class="fas fa-ban"></i>';
            $btnId = 'delete-'.$id;
            $btnClass = 'btn-danger';
        }

        $buttonDelete = '<a href="'.$deleteRoute.'" id="'.$btnId.'" class="my-ajax btn btn-sm '.$btnClass.'" title="Soft Delete">'.$deleteIcon.'</a>';

        $buttonForceDelete = '<a href="'.route('users.destroy',['user'=>$id]).'?hard=1" id="delete-'.$id.'" class="my-ajax btn btn-danger" title="Force Delete"><i class="fa fa-trash-alt"></i></a>';
        return $buttonEdit.$buttonDelete.$buttonForceDelete;
    }
    //<i class="fa fa-repeat" aria-hidden="true"></i>



    //SFRUTTO IL PACCHETTO DataTables PER FARE LE INTERROGAZIONI
    public function getUsers()
    {
        //->withTrashed() MI MOSTRA ANCHE QUELLI "SOFT_DELETED" (OVVERO CON deleted_at NOT NULL)
        $users = User::select(['id','name', 'email', 'role', 'created_at', 'deleted_at'])->withTrashed()->get();
        $result = DataTables::of($users)
            ->addColumn('action', function ($user) {
                return $this->getUserButtons($user);

            })->editColumn('created_at', function ($user){
                return $user->created_at->format('d/m/Y');

            })->editColumn('deleted_at', function ($user){
                return $user->deleted_at ? $user->deleted_at->format('d/m/Y') : $user->deleted_at;

            })->make(true);
        return $result;
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = new User();
        return view('admin.edituser', compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserFormRequest $request)
    {
        $user = new User();
        $user->password = bcrypt(\request()->input('email'));
        //VISTO CHE NON INSERISCO LA PASSWORD ME LA INVENTO UGUALE ALLA MAIL

        $user->fill($request->only(['email', 'role', 'name']));
        $res = $user->save();
        return redirect()->route('users.edit', ['user' => $user->id]);
        //aaaaaaaa
        //Invalid datetime format: 1292
        //Incorrect datetime value: '13-06-2020 00:00' for column 'updated_at'

        $messaggio = $res ? 'Utente CREATO' : 'Problema in CREATE';
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return "show ".$id;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('admin.edituser', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //CON UserFormRequest FACCIO SUBIRE AL FORM LE VALIDAZIONI
    public function update(UserFormRequest $request, User $user)
    {
//        return $request->all();
//        dd($request->only(['email', 'role', 'name']));
        $user->fill($request->only(['email', 'role', 'name']));
        $res = $user->save();
        return redirect()->route('users.edit', ['user' => $user->id]);
        //aaaaaaaa
        //Invalid datetime format: 1292
        //Incorrect datetime value: '13-06-2020 00:00' for column 'updated_at'

        $messaggio = $res ? 'Utente aggiornato' : 'Problema in update';

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //NN POSSO FARE TYPE HINTING XK SE IL RECORD E' CANCELLATO NON LO TROVA CON User
    public function destroy($id)
    {
        $user = User::withTrashed()->findOrFail($id);

        $hard = \request('hard', '');

        $res = $hard ? $user->forceDelete() : $user->delete();
        return ''.$res; //PERCHE' SI ASPETTA UNA STRINGA
    }



    public function restore($id) //NON POSSO FARE TYPHE HINTING
    {
        $user = User::withTrashed()->findOrFail($id);

        $res = $user->restore();
        return ''.$res; //PERCHE' SI ASPETTA UNA STRINGA
    }
}
