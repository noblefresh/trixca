<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCashoutsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('cashouts', function (Blueprint $table) {
      $table->uuid('id')->primary()->unique();
      $table->enum('type', ['normal', 'bonus', 'gift','sanction']);
      $table->decimal('total_amount', 18, 2);
      $table->decimal('recieved_amount', 18, 2);
      $table->decimal('recieving_amount', 18, 2);
      $table->enum('status', ['open', 'locked', 'closed', 'disabled']);
      $table->uuid('user_id');
      $table->uuid('investment_id')->nullable()->default(null);
      $table->timestamp('cashout_at', 6)->nullable()->default(null);
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
    Schema::dropIfExists('cashouts');
  }
}
