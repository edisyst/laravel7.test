<?php

namespace App\Http\Requests;

use App\Models\Album;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class AlbumUpdateRequest extends FormRequest
{

    //Determine if the user is authorized to make this request
    public function authorize()
    {
        $album = Album::find($this->id);
        if(Gate::denies('manage-album', $album)){
//        if(Gate::denies('update', $album)){   //USO UNA POLICY QUI
            return false;
        }
        return true;
    }


    //Get the validation rules that apply to the request
    public function rules()
    {
        return [
            'name'  => 'required|unique:albums,album_name', //'name' PERCHE' NEL FORM SI CHIAMA COSI'
//            'description' => 'required',
//            'album_thumb' => 'required|image',     //LO TOLGO PER UPDATE, L'img PUO' ESSERCI GIA'
//            'user_id'     => 'required',
        ];
    }


    //CREATA DA ME PER CUSTOMIZZARE I MSG DI ERRORE
    public function messages()
    {
        return [
            'name.required'  => 'Nome Album obbligatorio',
//            'description.required' => 'Descrizione obbligatoria',
//            'album_thumb.required' => 'Inserire una immagine',

        ];
    }
}
