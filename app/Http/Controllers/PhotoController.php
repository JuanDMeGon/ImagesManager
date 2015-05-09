<?php namespace ImagesManager\Http\Controllers;

use ImagesManager\Http\Requests;
use ImagesManager\Http\Controllers\Controller;

use Illuminate\Http\Request;

use ImagesManager\Http\Requests\ShowPhotosRequest;

use ImagesManager\Album;
use ImagesManager\Photo;

class PhotoController extends Controller {

	public function __construct()
	{
		$this->middleware('auth');
	}

	public function getIndex(ShowPhotosRequest $request)
	{
		$photos = Album::find($request->get('id'))->photos;


		return view('photos.show', ['photos' => $photos, 'id' => $request->get('id')]);
	}

	public function getCreatePhoto()
	{
		return 'showing the create Photo form';
	}

	public function postCreatePhoto()
	{
		return 'creating Photo';
	}

	public function getEditPhoto()
	{
		return 'showing the Edit Photo form';
	}

	public function postEditPhoto()
	{
		return 'editing Photo';
	}

	public function postDeletePhoto()
	{
		return 'deleting Photo';
	}

}
