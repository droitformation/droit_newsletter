<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class PageCreateRequest extends Request
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
            'title'      => 'required',
            'excerpt'    => 'required',
            'content'    => 'required'
        ];
    }

    public function messages()
    {
        return [
            'title.required'   => 'Le titre est requis',
            'excerpt.required' => 'Le extrait est requis',
            'content.required' => 'Le contenu est requis',
        ];
    }
}
