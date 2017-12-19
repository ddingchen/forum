@extends('layouts.app')

@section('style')
<link rel="stylesheet" href="/css/vendor/jquery.atwho.css">
@endsection

@section('content')
<thread-view inline-template :thread='{{ $thread }}'>
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                @include('thread._question')

                <replies @removed="count--" @created="count++"></replies>
            </div>

            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <p>
                            The thread was published {{ $thread->created_at->diffForHumans() }} by {{ $thread->creator->name }} and currently has @{{ this.count }} {{ str_plural('comment', $thread->replies_count) }}.
                        </p>
                        <p>
                            <subscribe-button :actived="{{ json_encode($thread->isSubscribedTo) }}"></subscribe-button>

                            <button class="btn btn-default"
                                v-if="authorize('isAdmin')"
                                @click="toggleLock"
                                v-text="locked ? 'Unlock' : 'Lock'"></button>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</thread-view>
@endsection
