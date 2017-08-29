<?php

namespace App\Http\Middleware;

use Closure;

class RedirectIfEmailNotConfirmed
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!auth()->user()->confirm) {
            return redirect('thread')->with([
                'flash.message' => 'Email must be confirmed first!.',
                'flash.status' => 'danger',
            ]);
        }
        return $next($request);
    }
}
