<?php

namespace employment_bank\Http\Middleware;

use Closure;
use Illuminate\Auth\Guard;
use Illuminate\Support\Facades\Auth;
class RedirectCandidateIfAuthenticated
{
    protected $auth;
    /**
     * Create a new filter instance.
     */
    public function __construct()
    {
        $this->auth = Auth::candidate();
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($this->auth->check()) {
            return redirect()->route('candidate.home');
        }

        return $next($request);
    }
}
