<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('notifications', function (Blueprint $table) {
      $table->uuid('id')->primary();
      $table->string('type');
      $table->uuid('notifiable_id');
      $table->string('notifiable_type');
      $table->text('data');
      $table->timestamp('read_at')->nullable()->default(null);
      $table->timestamp('created_at')->nullable()->default(null);
      $table->timestamp('updated_at')->nullable()->default(null);
      $table->timestamp('deleted_at')->nullable()->default(null);
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('notifications');
  }
}
