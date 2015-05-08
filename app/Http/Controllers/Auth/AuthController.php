<?php namespace ImagesManager\Http\Controllers\Auth;

use ImagesManager\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Registrar;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

use ImagesManager\User;
use ImagesManager\Http\Requests\PasswordRecoveryRequest;
use Hash;

class AuthController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Registration & Login Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles the registration of new users, as well as the
	| authentication of existing users. By default, this controller uses
	| a simple trait to add these behaviors. Why don't you explore it?
	|
	*/

	use AuthenticatesAndRegistersUsers;

	/**
	 * Create a new authentication controller instance.
	 *
	 * @param  \Illuminate\Contracts\Auth\Guard  $auth
	 * @param  \Illuminate\Contracts\Auth\Registrar  $registrar
	 * @return void
	 */
	public function __construct(Guard $auth, Registrar $registrar)
	{
		$this->auth = $auth;
		$this->registrar = $registrar;

		$this->middleware('guest', ['except' => 'getLogout']);
	}

	public function getRecoverPassword()
	{
		return view('auth.recover');
	}

	public function postRecoverPassword(PasswordRecoveryRequest $request)
	{
		$question = $request->get('question');
		$answer = $request->get('answer');

		$user = User::where('email', $request->get('email'))->first();

		if($user->question === $question && Hash::check($answer,$user->answer))
		{
			$user->password = bcrypt($request->get('password'));

			$user->save();

			return redirect('auth/login')
			->with(['success' => 'The password was changed']);
		}

		return redirect('auth/recover-password')->withInput($request->only('email', 'question'))
		->withErrors('The answer or the question doesn\'t match');
	}

}
