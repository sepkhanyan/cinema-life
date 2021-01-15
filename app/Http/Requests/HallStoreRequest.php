<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HallStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'cinema_id' => 'required|integer',
            'rows' => 'required|integer',
            'chairs' => 'required|integer',
            'title' => 'required|unique:halls,title'
        ];
    }
}
