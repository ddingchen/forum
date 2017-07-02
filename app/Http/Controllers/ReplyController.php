<?php

namespace App\Http\Controllers;

use App\Thread;

class ReplyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store($channelId, Thread $thread)
    {
        $this->validate(request(), ['body' => 'required']);

        $thread->replies()->create([
            'body' => request('body'),
            'user_id' => auth()->id(),
        ]);

        return back()->with('flash', 'Replied');
    }
}
