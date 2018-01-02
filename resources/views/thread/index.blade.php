@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            @forelse($threads as $thread)
                @include('thread._item')
            @empty
                <p>There are no relevent threads at this time.</p>
            @endforelse
        	{{ $threads->links() }}
        </div>
        <div class="col-md-4">

            <div class="panel panel-default">
                <div class="panel-heading">
                    Searching
                </div>
                <div class="panel-body">
                    <form method="GET" action="/thread/search">
                        <div class="form-group">
                            <input type="text" placeholder="Search for something ..." name="q" class="form-control">
                        </div>
                        <button class="btn btn-default">Submit</button>
                    </form>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">
                    Tending Threads
                </div>
                <div class="panel-body">
                    <ul class="list-group">
                    @foreach($trending as $thread)
                        <li class="list-group-item">
                            <a href="{{ $thread->path }}">
                                {{ $thread->title }}
                            </a>
                        </li>
                    @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
