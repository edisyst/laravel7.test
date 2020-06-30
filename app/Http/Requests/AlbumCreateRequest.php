<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AlbumCreateRequest extends FormRequest
{

    //Determine if the user is authorized to make this request
    public function authorize()
    {
        return true;
    }


    //Get the validation rules that apply to the request
    public function rules()
    {
        return [
            'name'  => 'required|unique:albums,album_name', //'name' PERCHE' NEL FORM SI CHIAMA COSI'
//            'description' => 'required',
            'album_thumb' => 'required|image',
//            'user_id'     => 'required',
        ];
    }


    //CREATA DA ME PER CUSTOMIZZARE I MSG DI ERRORE
    public function messages()
    {
        return [
            'name.required'  => 'Nome Album obbligatorio',
//            'description.required' => 'Descrizione obbligatoria',
            'album_thumb.required' => 'Inserire una immagine',

        ];
    }
}
