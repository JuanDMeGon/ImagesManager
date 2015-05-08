<?php namespace ImagesManager\Http\Controllers;

use ImagesManager\Http\Requests;
use ImagesManager\Http\Controllers\Controller;

use Illuminate\Http\Request;

use ImagesManager\Http\Requests\EditProfileRequest;

use Auth;

class UserController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}

	public function getEditProfile()
	{
		return view('user.edit-profile');
	}

	public function postEditProfile(EditProfileRequest $request)
	{
		$user = Auth::user();

		$user->name = $request->get('name');

		if($request->has('password'))
		{
			$user->password = bcrypt($request->get('password'));
		}

		if($request->has('question') || $request->has('answer'))
		{
			$user->question = $request->get('question');
			$user->answer = bcrypt($request->get('answer'));
		}

		$user->save();

		return redirect('/home')->with(['edited' => 'Your profile was succesfully edited']);

	}
}
