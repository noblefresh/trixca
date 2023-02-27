<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Closure;

class ActiveUser
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
      if(Auth::User()->blocked_at){
        $user = Auth::user();
        Auth::logout();
        return redirect()->route('blocked_user');
        // ->with('error','You can\'t continue, your accout was blocked');
      }
        return $next($request);
    }
}
