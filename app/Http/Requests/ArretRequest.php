<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ArretRequest extends Request
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
            'file' => 'required',
            'reference' => 'required',
            'pub_date' => 'required',
            'abstract' => 'required',
            'pub_text' => 'required'
        ];
    }
}
