@foreach($messages as $msg)
	@if($msg->from == Session::get('user.identity'))
		<div class="outgoing_msg">
		  	<div class="sent_msg">
				<p> {{$msg->body}} </p>
				<span class="time_date"> {{date_format($msg->dateCreated, 'd/m/Y | g:i A')}} </span>
			</div>
		</div>
	@else
		<h4> {{$msg->from}} </h4>
		<div class="incoming_msg">
			<div class="received_msg">
				<div class="received_withd_msg">
					<p> {{$msg->body}} </p>
					<span class="time_date"> {{date_format($msg->dateCreated, 'd/m/Y | g:i A')}} </span>
				</div>
			</div>
		</div>
	@endif
@endforeach