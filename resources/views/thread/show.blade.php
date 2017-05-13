@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <a href="#">{{ $thread->creator->name }}</a> posted {{ $thread->title }}
                </div>

                <div class="panel-body">
                    {{ $thread->body }}
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            @foreach($thread->replies as $reply)
                @include('thread.reply')
            @endforeach
        </div>
    </div>

    @if(Auth::check())
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <form method="post" action="/thread/{{ $thread->id }}/reply">
                {{ csrf_field() }}
                <div class="form-group">
                    <textarea name="body" class="form-control" rows="5" placeholder="say something ..."></textarea>
                </div>
                <button class="btn btn-default" type="submit">Submit</button>
            </form>
        </div>
    </div>
    @else
    <p class="text-center">Please <a href="{{ route('login') }}">sign in</a> to participate in forum.</p>
    @endif
</div>
@endsection
