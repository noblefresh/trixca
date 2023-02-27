<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::get('/', function () {
  return view('welcome');
});

Route::get('/unsupported/{flagged_country?}', function () {
  return view('unsupported_country');
})->name('unsupported_country');
Route::get('/access_denied', function () {
  return view('blocked_user');
})->name('blocked_user');


Route::get('/set-lang/{lang}', function ($lang) {
  session()->put('siteLangCode', $lang);
  return redirect()->back();
})->name('setLang')->where('lang', 'en|pt');


/* Authentication Routes */
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::get('email/verify', 'Auth\VerificationController@show')->name('verification.notice');
Route::get('email/verify/{id}/{hash}', 'Auth\VerificationController@verify')->name('verification.verify');
Route::post('email/resend', 'Auth\VerificationController@resend')->name('verification.resend');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::get('register/ref/{referer?}/', 'Auth\RegisterController@showRegistrationForm')->name('register_with_referer');
Route::post('register', 'Auth\RegisterController@register');
Route::get('password/confirm', 'Auth\ConfirmPasswordController@showConfirmForm')->name('password.confirm');
Route::post('password/confirm', 'Auth\ConfirmPasswordController@confirm');
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

Route::group(['prefix' => 'user', 'middleware' => ['auth', 'active_user']], function () {
  Route::get('/notifications', 'HomeController@notifications')->name('notifications');
  Route::get('/dashboard', 'HomeController@index')->name('user_dashboard')->middleware('verified');
  Route::get('/notifications', 'HomeController@notifications')->name('notifications');
  Route::group(['prefix' => 'profile', 'middleware' => ['verified']], function () {
    Route::get('/view', 'HomeController@view_profile')->name('view_profile');
    Route::get('/edit_profile', 'HomeController@edit_profile')->name('edit_profile');
    Route::get('/edit_momo', 'HomeController@edit_momo')->name('edit_momo');
    Route::post('/update_profile', 'HomeController@process_profile_update_data')->name('process_profile_update_data');
    Route::post('/update_momo', 'HomeController@process_momo_update_data')->name('process_momo_update_data');
    Route::get('/refered_users/referer_id/{referer_id}/level/{level}/ref_name/{ref_name}/{show_investments?}/', 'HomeController@refered_users')->name('refered_users');
  });
  Route::group(['prefix' => 'investment', 'middleware' => ['verified']], function () {
    Route::get('/list', 'InvestmentController@index')->name('list_investments');
    Route::get('/create', 'InvestmentController@create')->name('make_investment');
    Route::post('/process_new_investment', 'InvestmentController@store')->name('process_new_investment');
    Route::post('/process_cashout_bonus', 'InvestmentController@process_cashout_bonus')->name('process_cashout_bonus');
    Route::get('/show/{id}', 'InvestmentController@show')->name('show_investment');
  });
  Route::group(['prefix' => 'cashout', 'middleware' => ['verified']], function () {
    Route::get('/list', 'CashoutController@index')->name('list_cashouts');
    Route::post('/process_new_Cashout', 'CashoutController@store')->name('process_new_cashout');
    Route::get('/cashout_bonus', 'CashoutController@cashout_bonus')->name('cashout_bonus');
    Route::post('/process_cashout_bonus', 'CashoutController@process_cashout_bonus')->name('process_cashout_bonus');
    Route::get('/show/{id}', 'CashoutController@show')->name('show_cashout');
  });
  Route::group(['prefix' => 'post'], function () {
    Route::get('/create', 'PostController@create')->name('create_post');
    Route::post('/process_new_post', 'PostController@store')->name('process_new_post');
    Route::get('/create', 'PostController@create')->name('create_post');
    Route::get('/list', 'PostController@index')->name('list_post');
    Route::get('/show/{id}', 'PostController@show')->name('show_post');
    Route::get('/delete/{id}', 'PostController@destroy')->name('delete_post');
    Route::get('/delete_image/{id}', 'PostController@delete_post_image')->name('delete_post_image');
    Route::get('/edit/{id}', 'PostController@edit')->name('edit_post');
    Route::post('/update/{id}', 'PostController@update')->name('update_post');
  });
});

Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'active_user', 'is_admin']], function () {
  Route::get('/notifications', 'HomeController@notifications')->name('notifications');
  Route::get('/dashboard', 'HomeController@admin_dashboard')->name('admin_dashboard')->middleware('verified');
  Route::get('/create_transaction', 'TransactionController@create_transaction')->name('create_transaction')->middleware('verified');
  Route::get('/admin_list_users', 'HomeController@admin_index')->name('admin_list_users');

  Route::group(['prefix' => 'transactions', 'middleware' => ['verified']], function () {
    Route::get('/admin_list_transactions', 'TransactionController@admin_index')->name('admin_list_transactions');
  });
  Route::group(['prefix' => 'cashout', 'middleware' => ['verified']], function () {
    Route::get('/list', 'CashoutController@admin_index')->name('admin_list_cashouts');
    Route::post('/process_new_gift', 'CashoutController@store')->name('process_new_gift');
    Route::get('/gift', 'CashoutController@create')->name('gift_cashout');
    // Route::get('/cashout_bonus', 'CashoutController@cashout_bonus')->name('cashout_bonus');
    // Route::post('/process_cashout_bonus', 'CashoutController@process_cashout_bonus')->name('process_cashout_bonus');
    Route::get('/show/{id}', 'CashoutController@show')->name('show_cashout');
  });
  Route::group(['prefix' => 'investment', 'middleware' => ['verified']], function () {
    Route::get('/list', 'InvestmentController@admin_index')->name('admin_list_investments');
    Route::get('/show/{id}', 'InvestmentController@show')->name('show_investment');
  });
});
