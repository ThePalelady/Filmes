<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up()
  {
    Schema::create('movies', function (Blueprint $table) {
      $table->id();
      $table->string('name');
      $table->text('synopsis');
      $table->integer('year');
      $table->string('cover_image');
      $table->string('trailer_link');
      $table->timestamps();
    });
  }
  public function down(): void
  {
    Schema::dropIfExists('movies');
  }
};