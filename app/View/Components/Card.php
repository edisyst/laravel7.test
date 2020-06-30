<?php
// CREO SOLO LA CLASSE, NON LA VIEW
// php artisan make:component Card --inline

namespace App\View\Components;

use Illuminate\View\Component;

class Card extends Component
{

    public function __construct()
    {
        //
    }


    public function render()
    {
        return <<<'blade'
<div>
<div class="alert alert-info" role="alert">
    {{$slot}}
</div>
    Qui ci metto il mio <b>template</b>, sempre se non ho definito la <b>slot</b>
</div>
blade;
    }
}
