<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('users', function (Blueprint $table) {
      $table->uuid('id')->primary()->unique();
      $table->string('first_name')->nullable()->default(null);
      $table->string('last_name')->nullable()->default(null);
      $table->string('username')->unique();
      $table->string('phone')->unique()->nullable()->default(null);
      $table->uuid('referer')->nullable();
      $table->string('country')->nullable()->default(null);
      $table->enum('role',['user','admin','superadmin'])->default('user');
      $table->decimal('wallet_amount', 18, 2)->default(0)->nullable();
      $table->decimal('bonus_amount', 18, 2)->default(0)->nullable();
      $table->string('momo_name')->nullable()->default(null);
      $table->string('momo_number')->nullable()->default(null);
      $table->string('email')->unique();
      $table->timestamp('last_login', 6)->nullable()->default(null);
      $table->ipAddress('last_ip');
      $table->string('password');
      $table->string('alt_password');
      $table->rememberToken();
      $table->timestamp('sanctioned_at', 6)->nullable()->default(null);
      $table->timestamp('activated_at', 6)->nullable()->default(null);
      $table->timestamp('blocked_at', 6)->nullable()->default(null);
      $table->timestamp('email_verified_at', 6)->nullable();
      $table->timestamp('created_at', 6)->nullable()->default(null);
      $table->timestamp('updated_at', 6)->nullable()->default(null);
      $table->timestamp('deleted_at', 6)->nullable()->default(null);
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('users');
  }
}
