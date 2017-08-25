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
