<?php

namespace App\Providers;

use Illuminate\Database\Schema\Builder;
use Laravel\Passport\Passport;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Laravel\Passport\Client;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
      Passport::ignoreMigrations();
      //
      /**
       * Paginate a standard Laravel Collection.
       *
       * @param int $perPage
       * @param int $total
       * @param int $page
       * @param string $pageName
       * @return array
       */
      Collection::macro('paginate', function($perPage, $total = null, $page = null, $pageName = 'page') {
        $page = $page ?: LengthAwarePaginator::resolveCurrentPage($pageName);
        return new LengthAwarePaginator(
            $this->forPage($page, $perPage),
            $total ?: $this->count(),
            $perPage,
            $page,
            [
                'path' => LengthAwarePaginator::resolveCurrentPath(),
                'pageName' => $pageName
            ]
        );
    });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
      Paginator::defaultView('pagination.default');
      Paginator::defaultSimpleView('pagination.simple-default');
      Client::creating(function(Client $client){
        $client->incrementing =false;
        $client->id = Str::orderedUuid();
      });
      Client::retrieved(function(Client $client){
        $client->incrementing = false;
      });
      Builder::defaultStringLength(191);
    }
}
