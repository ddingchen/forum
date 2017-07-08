<reply inline-template :attributes="{{ $reply }}" v-cloak>
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
            <div v-if="editing">
                <div class="form-group">
                    <textarea class="form-control" v-model="body"></textarea>
                </div>
                <button class="btn btn-primary btn-xs" @click="update">Confirm</button>
                <button class="btn btn-link btn-xs" @click="editing = false">Cancel</button>
            </div>
            <div v-else v-text="body"></div>
        </div>

        @can('update', $reply)
        <div class="panel-footer level">
            <button class="btn btn-default btn-xs mr" @click="editing = true">Edit</button>
            <button class="btn btn-default btn-xs mr" @click="destroy">Delete</button>
        </div>
        @endcan
    </div>
</reply>
