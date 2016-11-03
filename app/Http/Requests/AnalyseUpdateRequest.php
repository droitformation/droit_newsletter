<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class AnalyseUpdateRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (\Auth::check())
        {
            return true;
        }

        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'author_id' => 'required',
            'pub_date' => 'required',
            'abstract' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'author_id.required'  => 'Un auteur est requis',
            'pub_date.required'     => 'La date est requise',
            'abstract.required'     => 'Le résumé est requis',
        ];
    }
}
