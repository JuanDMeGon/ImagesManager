@extends('app')

@section('content')

@if(Session::has('edited'))
	<div class="alert alert-success">
		<p>{{Session::get('edited')}}</p>
	</div>
@endif

@if(Session::has('deleted'))
	<div class="alert alert-success">
		<p>{{Session::get('deleted')}}</p>
	</div>
@endif

@if(Session::has('photo_created'))
	<div class="alert alert-success">
		<p>{{Session::get('photo_created')}}</p>
	</div>
@endif

<div class="container-fluid">
<p><a href="/validated/photos/create-photo?id={{$id}}" class="btn btn-primary" role="button">Create Photo</a></p>
@if(sizeof($photos) > 0)
	@foreach($photos as $index => $photo)
		@if($index%4 == 0)
		<div class="row">
		@endif
		  <div class="col-sm-6 col-md-3">
		    <div class="thumbnail">
		    	<img src="{{$photo->path}}">
		      <div class="caption">
		        <h3>{{$photo->title}}</h3>
		        <p>{{$photo->description}}</p>
		      </div>
		      <p><a href="/validated/photos/edit-photo/{{$photo->id}}" class="btn btn-primary" role="button">Edit Photo</a></p>
		      <form action="/validated/photos/delete-photo" method="POST">
				<input type="hidden" name="_token" value="{{ csrf_token() }}" required>
				<input type="hidden" name="id" value="{{$photo->id}}" required>
				<input class="btn btn-danger" role="button" type="submit" value="Delete"/>
			</form>
		    </div>
		  </div>
		@if(($index+1)%4 == 0)
		</div>
		@endif
	@endforeach
@else
<div class="alert alert-danger">
	<p>This album is empty. Please create a new photo.</p>
</div>
@endif
</div>
@endsection