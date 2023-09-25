@extends('layouts.app')
@section('content')
	<div class="card">
		<div class="card-header text-center alert-success">
			Create Channel
		</div>
		<div class="card-body">
			<form action="{{route('channel.store')}}" method="POST">
				@csrf
				<div class="form-group">
					<label for="name"> Name: </label>
					<input type="text" name="name" class="form-control">
				</div>
				<div class="form-group">
					<input type="submit" value="Create" class="btn btn-block btn-primary">
				</div>
			</form>
		</div>
	</div>
@endsection