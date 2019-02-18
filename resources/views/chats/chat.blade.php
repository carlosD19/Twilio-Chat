@extends('layouts.app')
@section('tittle', 'Chat')
<link href="{{ asset('css/chat.css') }}" rel="stylesheet">
<meta name="_token" content="{{csrf_token()}}"/>
@section('content')
	<div class="col-sm-12" style="padding-right: 3%; padding-left: 2%;">
		<h2>{{$channel->friendlyName}}</h2>
		<div class="messaging">
		  <div class="inbox_msg">
		  	<div class="mesgs">
		  		<div class="msg_history" id="rechargeMessage">

		  		</div>
				<div class="type_msg">
					<div class="input_msg_write">
						<form>
							<input type="text" class="write_msg" id="message" placeholder="Type a message">
							<input type="hidden" id="sid" value="{{$channel->sid}}">
							<button class="msg_send_btn" id="ajaxSubmit"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
						</form>
					</div>
				</div>
			</div>
			<div class="inbox_people">
				<div class="headind_srch">
					<div class="recent_heading">
						<h4>Members of chat</h4>
					</div>
				</div>
			    <div class="inbox_chat scroll" id="rechargeMembers">
					
			    </div>
			</div>
		  </div>
		</div>
	<div>
<script type="text/javascript" src="http://code.jquery.com/jquery.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		var isPaused = true;
		jQuery('#ajaxSubmit').click(function(e){
			isPaused = false;
           	e.preventDefault();
           	$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
				}
          	});
			jQuery.ajax({
				url: "{{ route('chats.send') }}",
				method: 'POST',
				data: {
					message: jQuery('#message').val(),
					sid: jQuery('#sid').val()
				},
				success: function(result){
					$('#message').val('');
					isPaused = true;
			}});
        });
		if (isPaused) {
			setInterval(
				function(){
					$('#rechargeMessage').load('message/{{$channel->sid}}');
					$("#rechargeMessage").animate({ scrollTop: $('#rechargeMessage')[0].scrollHeight}, 1000);
					$('#rechargeMembers').load('member/{{$channel->sid}}');
				}, 1500
			);
		}
	});
</script>
@endsection