@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="page-header">
			<h4>
				<a href="{{ route('profile', $profileUser->name) }}">{{ $profileUser->name }}</a>
				<small>{{ $profileUser->created_at->diffForHumans() }}</small>
			</h4>
		</div>

		@foreach($threads as $thread)
		<div class="panel panel-default">
            <div class="panel-heading">
            	<div class="level">
                	<span class="flex"><a href="#">{{ $thread->creator->name }}</a> posted <a href="{{ $thread->path() }}">{{ $thread->title }}</a></span>
            		<span>{{ $thread->created_at->diffForHumans() }}</span>
            	</div>
            </div>

            <div class="panel-body">
                {{ $thread->body }}
            </div>
        </div>
        @endforeach

        {{ $threads->links() }}
	</div>
@endsection
