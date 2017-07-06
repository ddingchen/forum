<div id="reply-{{ $reply->id }}" class="panel panel-default">
    <div class="panel-heading">
    	<div class="level">
        	<h5 class="flex">
        		<a href="{{ route('profile', $reply->owner->name) }}">{{ $reply->owner->name }}</a> said {{ $reply->created_at->diffForHumans() }}
        	</h5>
        	<form method="post" action="/reply/{{ $reply->id }}/favorites">
        		{{ csrf_field() }}
    			<button class="btn btn-default" {{ $reply->isFavorited()?'disabled':'' }} >{{ $reply->favorites_count }} {{ str_plural('favorite', $reply->favorites_count) }}</button>
        	</form>
    	</div>
    </div>

    <div class="panel-body">
        {{ $reply->body }}
    </div>

    @can('delete', $reply)
    <div class="panel-footer">
        <form method="post" action="/reply/{{ $reply->id }}">
            {{ csrf_field() }}
            {{ method_field('delete') }}
            <button type="submit" class="btn btn-danger btn-xs">Delete</button>
        </form>
    </div>
    @endcan
</div>
