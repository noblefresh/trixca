<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login', 'API\UserController@login');
Route::post('register', 'API\UserController@register');
Route::middleware('auth:api')->group(function () {

  Route::group(['prefix' => 'admin'], function () {
    Route::group(['prefix' => 'user'], function () {
      Route::get('/list/{status?}', 'HomeController@list');
      Route::get('/sanction/{username}', 'HomeController@sanction');
      Route::get('/block/{username}', 'HomeController@block');
      Route::get('/unblock/{username}', 'HomeController@unblock');
      Route::get('/find/by/id/{user_id}', 'HomeController@user_details');
      Route::get('/find/by/username/{user_name}', 'HomeController@user_data');
    });
    Route::group(['prefix' => 'investment'], function () {
      Route::get('list/{status?}', 'InvestmentController@list');
      Route::get('delete/{investment_id}', 'InvestmentController@destroy');
    });
    Route::group(['prefix' => 'cashout'], function () {
      Route::get('/list/{status?}', 'CashoutController@list');
      Route::get('/delete/{cashout_id}', 'CashoutController@destroy');
    });
    Route::group(['prefix' => 'transaction'], function () {
      Route::get('/list_all/{status?}', 'TransactionController@admin_list');
      Route::post('/create', 'TransactionController@store');
      Route::get('/extend/{transaction_id}/time/{hour}', 'TransactionController@extend_time');
    });
  });
  Route::group(['prefix' => 'user'], function () {
    Route::group(['prefix' => 'investment'], function () {
      Route::get('/list', 'InvestmentController@list');
    });
    Route::group(['prefix' => 'cashout'], function () {
      Route::get('/list', 'CashoutController@list');
    });
    Route::group(['prefix' => 'transaction'], function () {
      Route::get('/cashout_list/{user_id}', 'TransactionController@cashout_list');
      Route::get('/investment_list/{user_id}', 'TransactionController@investment_list');
      Route::post('/create', 'TransactionController@store');
      Route::post('/pop/upload', 'TransactionController@upload_pop');
      Route::get('/find/{transaction_id}/sender', 'TransactionController@view_sender');
      Route::get('/find/{transaction_id}/reciever', 'TransactionController@view_reciever');
      Route::get('/confirm/{transaction_id}', 'TransactionController@confirm');
      Route::get('/revoke/{transaction_id}', 'TransactionController@revoke');
      Route::get('/delete/{transaction_id}', 'TransactionController@delete');
      Route::get('/extend/{transaction_id}/time/{hour}', 'TransactionController@extend_time');
    });
  });
});
