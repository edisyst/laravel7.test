<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //X AUTORIZZARE IL FORM DEVO ESSERE ADMIN
        return Auth::user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required', 'string', 'email', 'max:255',
//                'unique:users'
                Rule::unique('users', 'email')->ignore($this->id, 'id')
            ], //DOVREI COMMENTARLA TUTTA
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'role' => [
                'required',
                Rule::in(['user', 'admin'])
            ],
        ];
    }



    //CUSTOMIZZAZIONE MSG DI ERRORE
    public function messages()
    {
        return [
            'email.required'  => 'Email obbligatoria',
            'role.required'  => 'Ruolo obbligatorio',
            'name.required'  => 'Nome obbligatorio',
            'email.unique'  => 'Email univoca',

        ];
    }
}
