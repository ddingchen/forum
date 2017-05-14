@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Create Thread</div>

                <div class="panel-body">
                    <form method="post" action="/thread">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label>Title</label>
                            <input class="form-control" name="title" />
                        </div>

                        <div class="form-group">
                            <label>Body</label>
                            <textarea class="form-control" rows="5" name="body"></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
