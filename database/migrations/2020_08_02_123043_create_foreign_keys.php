<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateForeignKeys extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('users', function (Blueprint $table) {
      $table->foreign('referer')->references('id')->on('users');
    });
    Schema::table('investments', function (Blueprint $table) {
      $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
      $table->foreign('cashout_id')->references('id')->on('cashouts');
    });
    Schema::table('cashouts', function (Blueprint $table) {
      $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
      $table->foreign('investment_id')->references('id')->on('investments')->onDelete('cascade');
    });
    Schema::table('transactions', function (Blueprint $table) {
      $table->foreign('investment_id')->references('id')->on('investments')->onDelete('cascade');
      $table->foreign('cashout_id')->references('id')->on('cashouts')->onDelete('cascade');
    });
    Schema::table('notifications', function (Blueprint $table) {
      $table->foreign('notifiable_id')->references('id')->on('users')->onDelete('cascade');
    });
    Schema::table('posts', function (Blueprint $table) {
      $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('users', function (Blueprint $table) {
      $table->dropForeign('referer');
    });
    Schema::table('investments', function (Blueprint $table) {
      $table->dropForeign('user_id');
      $table->dropForeign('cashout_id');
    });
    Schema::table('cashouts', function (Blueprint $table) {
      $table->dropForeign('user_id');
      $table->dropForeign('investment_id');
    });
    Schema::table('transactions', function (Blueprint $table) {
      $table->dropForeign('investment_id');
      $table->dropForeign('cashout_id');
    });
    Schema::table('notifications', function (Blueprint $table) {
      $table->dropForeign('notifiable_id');
    });
    Schema::table('posts', function (Blueprint $table) {
      $table->dropForeign('user_id');
    });
  }
}
