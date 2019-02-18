@foreach($members as $member)
	<div class="chat_list">
		<div class="chat_people">
			<div class="chat_ib">
				<h5> {{$member->identity}} </h5>
				<span class="chat_date"> {{$member->sid}} </span>
			</div>
		</div>
	</div>
@endforeach