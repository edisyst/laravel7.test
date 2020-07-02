<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserIdColumnAlbumCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        Schema::table('album_category', function (Blueprint $table) {
//            $table->integer('user_id')->unsigned()->index();
//            $table->foreign('user_id')->on('users')->references('id');
//        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
//        Schema::table('album_category', function (Blueprint $table) {
//            $table->dropColumn('user_id');
//        });
    }
}
