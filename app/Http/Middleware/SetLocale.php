<?php

namespace App\Http\Middleware;

use Closure;

class SetLocale
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
    if (session()->has('siteLangCode'))
      app()->setLocale(session('siteLangCode'));
    else
      app()->setLocale(config('app.locale'));

    return $next($request);
  }
}
