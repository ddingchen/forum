@extends('layouts.app')

@section('content')
<thread-view inline-template :init-replies-count='{{ $thread->replies_count }}'>
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="level">
                            <span class="flex">
                                <a href="{{ route('profile', $thread->creator->name) }}">{{ $thread->creator->name }}</a> posted {{ $thread->title }}
                            </span>
                            @can('delete', $thread)
                            <form method="post" action="{{ $thread->path() }}">
                                {{ csrf_field() }}
                                {{ method_field('delete') }}
                                <button type="submit" class="btn btn-default">Delete Thread</button>
                            </form>
                            @endcan
                        </div>

                    </div>

                    <div class="panel-body">
                        {{ $thread->body }}
                    </div>
                </div>

                <replies :replies="{{ $thread->replies }}" @removed="count--" @created="count++"></replies>

                {{ $replies->links() }}

                {{-- @if(Auth::check())
                    <form method="post" action="{{ $thread->path() }}/reply">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <textarea name="body" class="form-control" rows="5" placeholder="say something ..."></textarea>
                        </div>
                        <button class="btn btn-default" type="submit">Submit</button>
                    </form>
                @else
                    <p class="text-center">Please <a href="{{ route('login') }}">sign in</a> to participate in forum.</p>
                @endif --}}
            </div>

            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        The thread was published {{ $thread->created_at->diffForHumans() }} by {{ $thread->creator->name }} and currently has @{{ this.count }} {{ str_plural('comment', $thread->replies_count) }}.
                    </div>
                </div>
            </div>
        </div>
    </div>
</thread-view>
@endsection
