@extends('layouts.app')
@section('content')
<form action="{{route('problem.store')}}" method="POST">
	@csrf
	<input type="submit" value="submit">
</form>
@endsection