<?php

namespace App\Http\Controllers;

use App\Channel;
use App\Filters\ThreadFilter;
use App\Thread;
use App\Trending;
use Illuminate\Http\Request;

class ThreadController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Channel $channel = null, ThreadFilter $filter, Trending $trending)
    {
        $threads = $this->getThreads($channel, $filter);

        if (request()->wantsJson()) {
            return $threads;
        }

        $trending = $trending->get();

        return view('thread.index', compact('threads', 'trending'));
    }

    private function getThreads($channel, $filter)
    {
        // filter
        $threads = Thread::with('channel')->filter($filter)->latest();

        if ($channel->exists) {
            $threads = $threads->where('channel_id', $channel->id);
        }

        return $threads->paginate(20);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('thread.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|spam',
            'body' => 'required|spam',
            'channel_id' => 'required|exists:channels,id',
        ]);

        $thread = Thread::create([
            'title' => $request->input('title'),
            'slug' => str_slug($request->input('title')),
            'body' => $request->input('body'),
            'user_id' => auth()->id(),
            'channel_id' => $request->input('channel_id'),
        ]);
        return redirect($thread->path())->with('flash', 'Thread created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function show($channel, Thread $thread, Trending $trending)
    {
        if (auth()->check()) {
            auth()->user()->read($thread);
        }

        $thread->visits()->record();
        $trending->touch($thread);

        return view('thread.show', [
            'thread' => $thread,
            'replies' => $thread->replies()->paginate(10),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function edit(Thread $thread)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Thread $thread)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function destroy($channel, Thread $thread)
    {
        $this->authorize('delete', $thread);

        $thread->delete();
        if (request()->wantsJson()) {
            return response([], 204);
        }

        return redirect('thread');
    }
}
