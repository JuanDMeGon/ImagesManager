<?php namespace ImagesManager\Http\Controllers;

use ImagesManager\Http\Requests;
use ImagesManager\Http\Controllers\Controller;

use Illuminate\Http\Request;

use ImagesManager\Album;
use Auth;

use ImagesManager\Http\Requests\CreateAlbumRequest;
use ImagesManager\Http\Requests\EditAlbumRequest;
use ImagesManager\Http\Requests\DeleteAlbumRequest;

use ImagesManager\Http\Controllers\PhotoController;

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

	public function getEditAlbum($id)
	{
		$album = Album::find($id);
		return view('albums.edit-album', ['album' => $album]);
	}

	public function postEditAlbum(EditAlbumRequest $request)
	{
		$album = Album::find($request->get('id'));
		
		$album->title = $request->get('title');
		$album->description = $request->get('description');

		$album->save();

		return redirect('validated/albums')->with(['edited' => 'The album has been edited']);
	}

	public function postDeleteAlbum(DeleteAlbumRequest $request)
	{
		$album = ALbum::find($request->get('id'));

		$photos = $album->photos;

		$controller = new PhotoController;

		foreach ($photos as $photo)
		{
			$controller->deleteImage($photo->path);
			$photo->delete();
		}

		$album->delete();

		return redirect('validated/albums')->with(['deleted' => 'The album was deleted']);
	}

}
