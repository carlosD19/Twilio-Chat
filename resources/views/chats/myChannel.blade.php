<br><br>
<h2>Joined Channels</h2>
@if(Session::has('user'))
	@foreach($userChannels as $userChannel)
		<div class="row channels">
			@foreach($channels as $channel)
				@if($userChannel->channelSid == $channel->sid)
					<a href="{{ route('chats.channel', $channel->sid) }}">{{$channel->friendlyName}}
					</a>
				@endif
			@endforeach
		</div>
	@endforeach
@endif