@if(Session::has('info'))
	<div class="alert alert-info" style="width: 98%">
		<button type="button" class="close" data-dismiss="alert">
			&times;
		</button>
		{{ Session::get('info') }}
	</div>
@endif
