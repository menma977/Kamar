<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoomsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('rooms', function (Blueprint $table) {
      $table->id();
      $table->text("name");
      $table->integer("price")->index();
      $table->boolean("is_bond")->default(false);
      $table->boolean("is_man")->default(true);
      $table->date("join");
      $table->date("end")->nullable();
      $table->integer("item")->default(0);
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('rooms');
  }
}
