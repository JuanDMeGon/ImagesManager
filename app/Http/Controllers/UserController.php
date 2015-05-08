<?php namespace ImagesManager\Http\Controllers;

use ImagesManager\Http\Requests;
use ImagesManager\Http\Controllers\Controller;

use Illuminate\Http\Request;

class UserController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}

	public function getEditProfile()
	{
		return 'Showing the edit profile form';
	}

	public function postEditProfile()
	{
		return 'Changing the profile';
	}
}
