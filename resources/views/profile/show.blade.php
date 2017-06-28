@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="page-header">
			<h4>
				<a href="{{ route('profile', $profileUser->name) }}">{{ $profileUser->name }}</a>
				<small>{{ $profileUser->created_at->diffForHumans() }}</small>
			</h4>
		</div>

        @foreach($activitiesGroupByDay as $day => $activities)
            <h4 class="page-header">{{ $day }}</h4>
    		@foreach($activities as $activity)
                @include("profile.activities.{$activity->type}")
            @endforeach
        @endforeach
	</div>
@endsection
