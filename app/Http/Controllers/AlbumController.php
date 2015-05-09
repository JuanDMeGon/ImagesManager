<?php namespace ImagesManager\Http\Controllers;

use ImagesManager\Http\Requests;
use ImagesManager\Http\Controllers\Controller;

use Illuminate\Http\Request;

use ImagesManager\Album;
use Auth;

use ImagesManager\Http\Requests\CreateAlbumRequest;

class AlbumController extends Controller {

	public function __construct()
	{
		$this->middleware('auth');
	}

	public function getIndex()
	{
		$albums = Auth::user()->albums;
		return view('albums.show', ['albums' => $albums]);
	}

	public function getCreateAlbum()
	{
		return view('albums.create-album');
	}

	public function postCreateAlbum(CreateAlbumRequest $request)
	{
		$user = Auth::user();

		$title = $request->get('title');
		$description = $request->get('description');

		Album::create
		(
			[
				'title' => $title,
				'description' => $description,
				'user_id' => $user->id
			]
		);


		return redirect('validated/albums/')->with(['album_created' => 'The Album has been created.']);
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
