<?php namespace ImagesManager\Http\Requests;

use ImagesManager\Http\Requests\Request;

class PasswordRecoveryRequest extends Request {

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
		return
		[
			'email' => 'email|required|exists:users,email',
			'password' => 'required|min:6|confirmed',
			'question' => 'required',
			'answer' => 'required'
		];
	}

}
