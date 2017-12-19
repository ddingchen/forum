<div class="panel panel-default" v-if="!editing">
    <div class="panel-heading">
        <div class="level">
            <image class="mr" src="{{ $thread->creator->avatar_path }}" alt="{{ $thread->creator->name }}" width="25" height="25"/>
            <span class="flex">
                <a href="{{ route('profile', $thread->creator->name) }}">{{ $thread->creator->name }}</a> posted {{ $thread->title }}
            </span>
        </div>
    </div>

    <div class="panel-body">
        {{ $thread->body }}
    </div>

    <div class="panel-footer">
        <button class="btn btn-default btn-xs" @click="edit">Edit</button>
    </div>
</div>

<div class="panel panel-default" v-if="editing">
    <div class="panel-heading">
        <div class="level">
            <input type="text" class="form-control mr" value="{{ $thread->title }}">
        </div>
    </div>

    <div class="panel-body">
        <textarea class="form-control" rows="10">{{ $thread->body }}</textarea>
    </div>

    <div class="panel-footer">
        <div class="level">
            <button class="btn btn-primary btn-xs mr">Update</button>
            <button class="btn btn-default btn-xs mr" @click="cancel">Cancel</button>

            @can('update', $thread)
            <form method="post" action="{{ $thread->path() }}" class="ml-a">
                {{ csrf_field() }}
                {{ method_field('delete') }}
                <button type="submit" class="btn btn-danger btn-xs">Delete Thread</button>
            </form>
            @endcan
        </div>
    </div>
</div>
