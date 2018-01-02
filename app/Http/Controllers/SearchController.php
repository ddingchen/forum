<?php

namespace App\Http\Controllers;

use App\Thread;
use App\Trending;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    
    public function show(Trending $trending)
    {
        $query = request('q');

        $threads = Thread::search($query)->paginate(25);

        if (request()->expectsJson()) {
            return $threads;
        }

        return view('thread.index', [
            'threads' => $threads,
            'trending' => $trending->get(),
        ]);
    }

}
