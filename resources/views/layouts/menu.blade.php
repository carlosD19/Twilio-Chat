@if(Session::has('user'))
  <link href="{{ asset('css/menu.css') }}" rel="stylesheet">
  <nav class="navbar navbar-expand-lg navbar-light" style="margin-bottom: 0; border: 0.5px solid gray; background-color: #232f3e">
    <div class="container-fluid">
      <div class="navbar-header">
        <a class="navbar-brand" id="navbarTittle" href="/chats">Twilio Chat</a>
      </div>
        <ul class="nav navbar-nav">
          <li id="navbarTittle">
            <label style="padding-top: 10px;"> {{ Session::get('user.identity') }} </label>
          </li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <li><a href="{{ url('logout') }}" id="navbarMenu"><i class="fas fa-sign-out-alt fa-rotate-180"></i> Sign out </a></li>
        </ul>
      </div>
    </div>
  </nav>
@endif