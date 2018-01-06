@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <ais-index
            app-id="{{ config('scout.algolia.id') }}"
            api-key="{{ config('scout.algolia.key') }}"
            index-name="threads"
            query="{{ request('q') }}">

            <div class="col-md-8">
                <ais-results>
                    <template scope="{ result }">
                        <li>
                            <a href="">
                                <ais-highlight :result="result" attribute-name="title"></ais-highlight>
                            </a>
                        </li>
                    </template>
                </ais-results>
            </div>

            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Search something ...
                    </div>
                    <div class="panel-body">
                        <ais-search-box>
                            <ais-input placeholder="Find products..." autofocus="true" class="form-control"></ais-input>
                        </ais-search-box>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">
                        Filter by channel
                    </div>
                    <div class="panel-body">
                        <ais-refinement-list attribute-name="channel.name"></ais-refinement-list>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">
                        Tending Threads
                    </div>
                    <div class="panel-body">
                        <ul class="list-group">
                        @foreach($trending as $thread)
                            <li class="list-group-item">
                                <a href="{{ $thread->path }}">
                                    {{ $thread->title }}
                                </a>
                            </li>
                        @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </ais-index>
    </div>
</div>
@endsection
