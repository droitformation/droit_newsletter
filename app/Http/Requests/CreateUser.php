<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class CreateUser extends Request {

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
			'first_name' => 'required',
			'last_name'  => 'required',
            'email'      => 'required|email|max:255|unique:users',
            'password'   => 'required|min:6',
        ];
	}

}
