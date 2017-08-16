<?php

namespace App\Http\Controllers;

use App\Inspections\Spam;
use App\Reply;
use App\Thread;

class ReplyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index']]);
    }

    public function index($channelId, Thread $thread)
    {
        return $thread->replies()->paginate(10);
    }

    public function store($channelId, Thread $thread, Spam $spam)
    {
        $this->validate(request(), ['body' => 'required']);
        $spam->detect(request('body'));

        $reply = $thread->addReply([
            'body' => request('body'),
            'user_id' => auth()->id(),
        ]);

        if (request()->wantsJson()) {
            return $reply->load('owner');
        }

        return back()->with('flash', 'Replied');
    }

    public function update(Reply $reply, Spam $spam)
    {
        $this->authorize('update', $reply);

        $this->validate(request(), ['body' => 'required']);
        $spam->detect(request('body'));

        $reply->update(request(['body']));
    }

    public function destroy(Reply $reply)
    {
        $this->authorize('update', $reply);

        $reply->delete();

        if (request()->wantsJson()) {
            return response([], 204);
        }
        return back();
    }
}
