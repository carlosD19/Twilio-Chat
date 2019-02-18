@extends('layouts.app')
@section('tittle', 'Login')
<link href="{{ asset('css/login.css') }}" rel="stylesheet">

@section('content')
<div class="login-wrap">
@include('security.partials.info')
  <div class="login-html">
    <input id="tab-1" type="radio" name="tab" class="sign-in" checked><label for="tab-1" class="tab">Sign In</label>
    <input id="tab-2" type="radio" name="tab" class="sign-up"><label for="tab-2" class="tab">Sign Up</label>
    <div class="login-form">
      <form class="sign-in-htm" method="POST" action="{{ url('login') }}">
        <br>
        {{ csrf_field() }}
        <div class="group">
          <label for="user" class="label">Username</label>
          <input id="usernameLogin" name="usernameLogin" type="text" class="input">
          @if ($errors->has('usernameLogin'))
            <span class="invalid-feedback" role="alert">
              <strong style="color: rgb(255, 55, 64)">The Username field is required.</strong>
            </span>
          @endif
        </div>
        <div class="group">
          <label for="pass" class="label">Password</label>
          <input id="passwordLogin" name="passwordLogin" type="password" class="input" data-type="password">
          @if ($errors->has('passwordLogin'))
            <span class="invalid-feedback" role="alert">
              <strong style="color: rgb(255, 55, 64)">The Password field is required.</strong>
            </span>
          @endif
        </div>
        <br>
        <div class="group">
          <input type="submit" class="button" value="Sign In">
        </div>
        <div class="group">
          <a href="{{ url('chats')}}" style="text-decoration:none;">
          <input class="button" style="text-align: center;cursor:hand;" id="primary" value="Viewer Mode">
          </a>
        </div>
        <div class="hr"></div>
      </form>
      <form class="sign-up-htm" method="POST" action="{{ url('register') }}">
        <br>
        {{ csrf_field() }}
        <div class="group">
          <label for="user" class="label">Username</label>
          <input id="usernameSignup" name="usernameSignup" type="text" class="input">
          @if ($errors->has('usernameSignup'))
            <span class="invalid-feedback" role="alert">
              <strong style="color: rgb(255, 55, 64)">The Username field is required.</strong>
            </span>
          @endif
        </div>
        <div class="group">
          <label for="pass" class="label">Password</label>
          <input id="passwordSignup" name="passwordSignup" type="password" class="input" data-type="password">
          @if ($errors->has('passwordSignup'))
            <span class="invalid-feedback" role="alert">
              <strong style="color: rgb(255, 55, 64)">The password must be less than or equal to 3 characters.</strong>
            </span>
          @endif
        </div>
        <div class="group">
          <label for="pass" class="label">Confirm Password</label>
          <input id="passwordConfirm" name="passwordConfirm" type="password" class="input" data-type="password">
          @if ($errors->has('passwordConfirm'))
            <span class="invalid-feedback" role="alert">
              <strong style="color: rgb(255, 55, 64)">Passwords do not match.</strong>
            </span>
          @endif
        </div>
        <div class="group">
          <input type="submit" class="button" value="Sign Up">
        </div>
        <div class="hr"></div>
      </form>
    </div>
  </div>
</div>
@endsection
