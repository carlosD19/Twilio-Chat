@extends('layouts.app')
@section('tittle', 'Channel')
@section('content')
	<div class="col-sm-4" style="padding-left: 4%">
		@include('channels.create')
	</div>
	<div class="col-sm-8" style="padding-left: 2%">
		@include('channels.read')
	<div>
@endsection