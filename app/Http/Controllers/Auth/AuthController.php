<?php namespace ImagesManager\Http\Controllers\Auth;

use ImagesManager\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Registrar;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

use ImagesManager\User;
use ImagesManager\Http\Requests\PasswordRecoveryRequest;
use Hash;
use Validator;

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
	public function __construct()
	{

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

	public function validator(array $data)
	{
		return Validator::make($data, [
			'name' => 'required|max:255',
			'email' => 'required|email|max:255|unique:users',
			'password' => 'required|confirmed|min:6',
			'question' => 'required|max:255',
			'answer' => 'required|confirmed|max:255',
		]);
	}

	/**
	 * Create a new user instance after a valid registration.
	 *
	 * @param  array  $data
	 * @return User
	 */
	public function create(array $data)
	{
		return User::create([
			'name' => $data['name'],
			'email' => $data['email'],
			'password' => bcrypt($data['password']),
			'question' => $data['question'],
			'answer' => bcrypt($data['answer']),
		]);
	}

}
