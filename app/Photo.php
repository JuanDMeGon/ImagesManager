<?php namespace ImagesManager;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model {

	protected $table = 'photos';

	protected $fillable = ['id', 'title', 'description', 'path', 'album_id'];

	public function album()
	{
		return belongsTo('ImagesManager\Album');
	}

}
