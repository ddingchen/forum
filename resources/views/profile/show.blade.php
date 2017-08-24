@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="page-header">
			<h4>
				<a href="{{ route('profile', $profileUser->name) }}">{{ $profileUser->name }}</a>
				<small>{{ $profileUser->created_at->diffForHumans() }}</small>
			</h4>

            @can('update', $profileUser)
                <form method="post" action="{{ route('avatar', ['user'=>$profileUser]) }}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="file" name="avatar">
                    <button class="btn btn-default">Submit</button>
                </form>
                <image src="/storage/{{ $profileUser->avatarPath() }}" width="200" height="200" />
            @endcan
		</div>



        @foreach($activitiesGroupByDay as $day => $activities)
            <h4 class="page-header">{{ $day }}</h4>
    		@foreach($activities as $activity)
    			@if(view()->exists("profile.activities.{$activity->type}"))
                	@include("profile.activities.{$activity->type}")
                @endif
            @endforeach
        @endforeach
	</div>
@endsection
