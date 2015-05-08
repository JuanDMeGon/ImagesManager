<?php namespace ImagesManager\Http\Controllers;

use ImagesManager\Http\Requests;
use ImagesManager\Http\Controllers\Controller;

use Illuminate\Http\Request;

class AlbumController extends Controller {

	public function __construct()
	{
		$this->middleware('auth');
	}

	public function getIndex()
	{
		return 'Showing all the user Albums';
	}

	public function getCreateAlbum()
	{
		return 'showing the create album form';
	}

	public function postCreateAlbum()
	{
		return 'creating album';
	}

	public function getEditAlbum()
	{
		return 'showing the Edit album form';
	}

	public function postEditAlbum()
	{
		return 'editing album';
	}

	public function postDeleteAlbum()
	{
		return 'deleting album';
	}

}
