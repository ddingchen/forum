<?php

namespace App\Http\Controllers;

use App\Reply;

class FavoriteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Reply $reply)
    {
        $reply->favorite();

        if (request()->wantsJson()) {
            return response([], 200);
        }

        return back();
    }

    public function destroy(Reply $reply)
    {
        $reply->unfavorite();

        if (request()->wantsJson()) {
            return response([], 204);
        }

        return back();
    }
}
