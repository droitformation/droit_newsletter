<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class SendMessageRequest extends Request {

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
            'nom'      => 'required',
            'email'    => 'required|email',
            'remarque' => 'required',
            'my_name'  => 'honeypot',
            'my_time'  => 'required|honeytime:5'
		];
	}

}
