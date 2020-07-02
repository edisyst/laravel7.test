<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check(); //IN REALTA' NON SERVE PERCHE' HO GIA' IL MIDDLEWARE Auth SU TUTTE LE ROTTE DI Category
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'category_name' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'category_name.required'  => 'Nome Categoria obbligatorio',
        ];
    }
}
