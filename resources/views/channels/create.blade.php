<br><br><h2 class="pull-center">Add Channel</h2><br>
<div class="row" style="border: 1px solid black; border-radius: 25px; padding: 5%">
    <form method="POST" action="{{ route('channels.store') }}">
        <div class="form-group">
            <label>Name of Channel</label>
            <input type="text" name="name" id="name" class="form-control" required placeholder="Name of Channel">
        </div>
        <div class="form-group">
            {{ csrf_field() }}
            <button type="submit" class="btn btn-primary" name="save">Save</button>
        </div>
    </form>
</div>
       