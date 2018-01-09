<div class="panel panel-default" v-if="!editing">
    <div class="panel-heading">
        <div class="level">
            <image class="mr" src="{{ $thread->creator->avatar_path }}" alt="{{ $thread->creator->name }}" width="25" height="25"/>
            <span class="flex">
                <a href="{{ route('profile', $thread->creator->name) }}">{{ $thread->creator->name }}</a> posted <span v-text="title"></span>
            </span>
        </div>
    </div>

    <div class="panel-body" v-html="body"></div>

    <div class="panel-footer" v-if="authorize('owner', thread)">
        <button class="btn btn-default btn-xs" @click="edit">Edit</button>
    </div>
</div>

<div class="panel panel-default" v-if="editing">
    <div class="panel-heading">
        <div class="level">
            <input type="text" class="form-control mr" v-model="form.title">
        </div>
    </div>

    <div class="panel-body">
        <wysiwyg v-model="form.body" :value="form.body"></wysiwyg>
    </div>

    <div class="panel-footer">
        <div class="level">
            <button class="btn btn-primary btn-xs mr" @click="update">Update</button>
            <button class="btn btn-default btn-xs mr" @click="resetForm">Cancel</button>

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
