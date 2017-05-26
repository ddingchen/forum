<?php

namespace App\Filters;

use App\Filters\Filter;
use Illuminate\Http\Request;

/**
 * Filter of threads
 */
class ThreadFilter extends Filter
{

    protected $filters = ['by', 'popular'];

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    protected function by($username)
    {
        return $this->builder->by($username);
    }

    protected function popular()
    {
        return $this->builder->orderBy('replies_count', 'desc');
    }

}
