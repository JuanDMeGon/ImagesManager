<?php namespace ImagesManager\Http\Controllers;

use ImagesManager\Http\Requests;
use ImagesManager\Http\Controllers\Controller;

use Illuminate\Http\Request;

use ImagesManager\Http\Requests\ShowPhotosRequest;

use ImagesManager\Album;
use ImagesManager\Photo;
use Carbon\Carbon;

use ImagesManager\Http\Requests\CreatePhotoRequest;
use ImagesManager\Http\Requests\EditPhotoRequest;

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

	public function getCreatePhoto(Request $request)
	{
		$id = $request->get('id');

		return view('photos.create-photo', ['id' => $id]);
	}

	public function postCreatePhoto(CreatePhotoRequest $request)
	{
		$image = $request->file('image');
		$id = $request->get('id');
		Photo::create
		(
			[
				'title' => $request->get('title'),
				'description' => $request->get('description'),
				'path' => $this->createImage($image),
				'album_id' => $id
			]
		);
		return redirect("validated/photos?id=$id")->with(['photo_created' => 'The photo has been created']);
	}

	public function getEditPhoto($id)
	{
		$photo = Photo::find($id);
		return view('photos.edit-photo', ['photo' => $photo]);
	}

	public function postEditPhoto(EditPhotoRequest $request)
	{
		$photo = Photo::find($request->get('id'));

		$photo->title = $request->get('title');
		$photo->description = $request->get('description');

		if($request->hasFile('image'))
		{
			$this->deleteImage($photo->path);

			$image = $request->file('image');

			$photo->path = $this->createImage($image);
		}

		$photo->save();

		return redirect("validated/photos?id=$photo->album_id")->with(['edited' => 'The photo was edited']);
	}

	public function postDeletePhoto()
	{
		return 'deleting Photo';
	}

	public function createImage($image)
	{
		$path = '/img/';

		$name = sha1(Carbon::now()).'.'.$image->guessExtension();

		$image->move(getcwd().$path, $name);

		return $path.$name;
	}

	public function deleteImage($oldpath)
	{
		$oldpath = getcwd().$oldpath;

		unlink(realpath($oldpath));
	}

}
