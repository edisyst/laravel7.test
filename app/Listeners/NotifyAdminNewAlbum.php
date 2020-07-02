<?php

namespace App\Listeners;

use App\Events\NewAlbumCreated;
use App\Mail\EmailNotifyAdminNewAlbum;
use App\Models\Album;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class NotifyAdminNewAlbum
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  NewAlbumCreated  $event
     * @return void
     */
    //RICEVE UN'ISTANZA DELL'EVENT COLLEGATO AD ESSO
    public function handle(NewAlbumCreated $event)
    {
//        dd($event->album->album_name);
        $admins = User::where('role', 'admin')->get(); //TUTTI GLI UTENTI ADMIN
        foreach ($admins as $admin) {
            Mail::to($admin->email)
                ->send(new EmailNotifyAdminNewAlbum($event->album));
        }

    }
}
