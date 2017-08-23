@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            @forelse($threads as $thread)
                @include('thread._item')
            @empty
                <p>There are no relevent threads at this time.</p>
            @endforelse
        	{{ $threads->links() }}
        </div>
    </div>
</div>
@endsection
