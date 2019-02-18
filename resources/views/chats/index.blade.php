@extends('layouts.app')
@section('tittle', 'Channels')
<link href="{{ asset('css/channel.css') }}" rel="stylesheet">
@section('content')
	<div class="col-sm-3" style="padding-left: 5%;">
		@include('chats.myChannel')
	</div>
	<div class="col-sm-9" style="padding-left: 3%">
		@include('chats.channel')
	<div>
@endsection
