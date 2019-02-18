<div class="col-sm-12" style="padding-left: 2%">
	<br><br><h2>List of Channels</h2><br>
	@include('channels.partials.info')
	<table class="table table-hover table-striped table-bordered" style="width: 98%">
		<thead>
			<tr>
				<th style="text-align: center;">SID</th>
				<th style="text-align: center;">Name</th>
				<th style="text-align: center;" colspan="2">Action</th>
			</tr>
		</thead>
		<tbody>
			@foreach($channels as $channel)
			<tr>
				<td>{{$channel->sid}}</td>
				<td>{{$channel->friendlyName}}</td>
				<td>
					<a href="{{ route('channels.edit', $channel->sid) }}" class="btn btn-info">
						<i class="fas fa-edit"></i>
                    </a>
                </td>
				<td>
					<form action="{{ route('channels.destroy', $channel->sid) }}" method="POST">
						{{ csrf_field() }}
						<input type="hidden" name="_method" value="DELETE">
						<button class="btn btn-danger">
                                <i class="fas fa-trash-alt"></i>
                        </button>
					</form>
                </td>
			</tr>
			@endforeach
		</tbody>
	</table>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>