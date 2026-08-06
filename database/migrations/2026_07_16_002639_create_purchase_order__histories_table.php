<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::create('purchase_order__histories', function (Blueprint $table) {
      $table->id();
      $table->enum('order_status', ['Cancelado', 'Pendiente', 'En preparación', 'Entregado', 'Disponible'])
        ->default('Pendiente');
      $table->string('notes')
      ->nullable();
      $table->foreignId('purchase_order_id')
        ->constrained();
      $table->foreignId('user_id')
        ->constrained();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('purchase_order__histories');
  }
};
