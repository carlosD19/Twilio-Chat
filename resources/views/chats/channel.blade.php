<br><br>
<h1>List of Channels</h1>
@foreach($channels as $channel)
	<div class="col-xs-3 card">
		<br><br>
		<div class="container">
			<h4><b>{{$channel->friendlyName}}</b></h4> 
			<a href="{{ route('chats.join', $channel->sid) }}" class="btn btn-primary">Join</a> 
		</div>
		<br>
	</div>
@endforeach