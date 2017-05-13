<?php

namespace App\Http\Controllers;

use App\Thread;

class ReplyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Thread $thread)
    {
        $thread->replies()->create([
            'body' => request('body'),
            'user_id' => auth()->id(),
        ]);

        return back();
    }
}
