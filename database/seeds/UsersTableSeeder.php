<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
//use Psy\Util\Str;
use \Illuminate\Support\Carbon;

class UsersTableSeeder extends Seeder
{


    //POPOLO LA TABELLA users CON VALORI RANDOM
    public function run()
    {


//PRIMO MODO: SCRIVO LA QUERY SQL
        $sql = "INSERT INTO users (name, email, role, password)";
        $sql.= " VALUES (:name, :email, :role, :password)";

        DB::statement($sql, [
            'name'     => 'Amministratore',
            'email'    => 'admin@gmail.com',
            'role'     => 'admin',
            'password' => Hash::make('admin')
        ]);


//SECONDO MODO: PIU' BREVE
        DB::table('users')->insert([
            'name'     => Str::random(8),
            'email'    => 'edoardo@gmail.com',
            'role'     => 'user',
            'password' => Hash::make('edoardo'),
            'created_at'=>Carbon::now(),
        ]);



        /*
//PRIMA SVUOTO LA TABELLA
        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=0');
        \App\Models\User::truncate();
        */

//HELPER CHE MAPPA ALLA CLASSE factory
        $users = factory(\App\Models\User::class, 5)->create();


    }
}
