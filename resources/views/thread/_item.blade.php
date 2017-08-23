<div class="panel panel-default">
    <div class="panel-heading">
        <div class="level">
            <div class="flex">
                <a href="{{ $thread->path() }}" class="flex"><h4>
                    @if(Auth::check() && $thread->hasUpdatesFor())
                        <strong>{{ $thread->title }}</strong>
                    @else
                        {{ $thread->title }}
                    @endif
                </h4></a>
                <h5>Posted by: <a href="{{ route('profile', ['user'=>$thread->creator]) }}">{{ $thread->creator->name }}</a></h5>
            </div>
            <a href="{{ $thread->path() }}">{{ $thread->replies_count }} {{ str_plural('reply', $thread->replies_count) }}</a>
        </div>
    </div>

    <div class="panel-body">
        <div class="body">{{ $thread->body }}</div>
    </div>
</div>
