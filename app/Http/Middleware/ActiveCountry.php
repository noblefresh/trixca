<?php

namespace App\Http\Middleware;

use Closure;
use PulkitJalan\GeoIP\Facades\GeoIP;

class ActiveCountry
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
      $requester_country = GeoIP::getCountry();
      if(!in_array($requester_country, ['Nigeria','Ghana','South Africa','Cameroon','Uganda','Kenya','Zimbabwe']))
      {
        return redirect()->route('unsupported_country',['flagged_country'=>$requester_country]);
      }
        return $next($request);
    }
}
