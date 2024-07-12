<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('super_users')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreignId('barbershop_id')->references('id')->on('barbershops')->restrictOnDelete()->cascadeOnUpdate();
            $table->string('payer_name');
            $table->unsignedInteger('amount');
            $table->unsignedInteger('days_added');
            $table->string('note')->nullable();
            $table->string('payment_image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
