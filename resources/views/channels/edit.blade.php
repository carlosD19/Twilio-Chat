@extends('layouts.app')

@section('content')
<div class="col-sm-4" style="padding-left: 4%"><br><br>
    <h2 class="pull-center">Modify Channel</h2><br>
    <div class="row" style="border: 1px solid black; border-radius: 25px; padding: 5%">
        <form method="POST" action="{{ route('channels.update', $channel->sid) }}" role="form">
            {{ csrf_field() }}
            <input name="_method" type="hidden" value="PATCH">
            <div class="form-group">
                <label>Name of Channel</label>
                <input type="text" name="name" id="name" class="form-control" required placeholder="Name of Channel" value="{{$channel->friendlyName}}">
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Modify</button>
                <a class="btn btn-danger" href="{{ route('channels.index')}}">Cancel</a>
            </div>
        </form>
    </div>
</div>
<div class="col-sm-8" style="padding-left: 2%">
    @include('channels.read')
</div>
@endsection