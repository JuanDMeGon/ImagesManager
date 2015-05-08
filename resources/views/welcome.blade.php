@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">

			@if (count($errors) > 0)
				<div class="alert alert-danger">
					<strong>Whoops!</strong> Something fails.<br><br>
					<ul>
						@foreach ($errors->all() as $error)
							<li>{{ $error }}</li>
						@endforeach
					</ul>
				</div>
			@endif
				<div class="panel-heading">Home</div>

				<div class="panel-body">
					Welcome, please login or create an account
				</div>
			</div>
		</div>
	</div>
</div>
@endsection