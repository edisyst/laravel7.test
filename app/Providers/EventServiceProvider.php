<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    //DICHIARO GLI EVENTI DA SCATENARE: UN ARRAY PER OGNI EVENTO
    protected $listen = [
        //QUESTO ARRAY L'HO COMMENTATO PER TESTARE EVENT+LISTENER
        //SE NON FUNGE QUALCOSA, DECOMMENTARE O VEDERE DOCUMENTAZIONE
//        Registered::class => [
//            SendEmailVerificationNotification::class,
//        ],
        'App\Events\NewAlbumCreated' => [
            'App\Listeners\NotifyAdminNewAlbum',
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
