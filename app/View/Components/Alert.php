<?php
// composer require laravel/helpers
// php artisan serve
// php artisan make:component Alert

//DEVO AGGIUNGERGLI LE PROPRIETA' CHE INTENDO INIETTARGLI

namespace App\View\Components;

use Illuminate\View\Component;

class Alert extends Component
{
    public $info;
    public $message;
    public $name;

    public function __construct($info='' , $message='' , $name='')
    {
        $this->info = $info;
        $this->message = $message;
        $this->name = $name;
    }


    public function render()
    {
        return view('components.alert');
    }
}
