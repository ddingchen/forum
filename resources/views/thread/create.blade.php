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
                            <label for="channel_id">Choose a channel</label>
                            <select class="form-control" name="channel_id" required>
                                <option value="">Choose a channel</option>
                                @foreach($channels as $channel)
                                <option value="{{ $channel->id }}" {{ old('channel_id') == $channel->id ? 'selected' : '' }}>{{ $channel->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Title</label>
                            <input class="form-control" name="title" value="{{ old('title') }}" required/>
                        </div>

                        <div class="form-group">
                            <label>Body</label>
                            <textarea class="form-control" rows="5" name="body" required>{{ old('body') }}</textarea>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                        @if(count($errors))
                        <ul class="alert alert-danger">
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
