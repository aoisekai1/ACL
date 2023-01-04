<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Acl;

class AuthLogin
{
    public function __construct()
    {
        $this->acl = new Acl;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(!$this->acl->checkMySession()){
            return redirect()->guest('login');
        }
        return $next($request);
    }
}
