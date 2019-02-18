@if(Session::has('info'))
	<div class="alert alert-info" id="error">
		<button class="close" data-dismiss="alert">
			&times;
		</button>
		{{ Session::get('info') }}
	</div>
@endif
