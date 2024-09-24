<?php

use App\Enums\OrderStatusEnum;
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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number');
            $table->foreignId('barbershop_id')->constrained('barbershops')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete()->cascadeOnUpdate();
            $table->foreignId('member_id')->nullable()->constrained('members')->nullOnDelete()->cascadeOnUpdate();
            $table->foreignId('seat_id')->nullable()->constrained('seats')->nullOnDelete()->cascadeOnUpdate();

            $table->time('est_start');
            $table->time('est_finish');
            $table->time('actual_start');
            $table->time('actual_finish');
            $table->enum('status', OrderStatusEnum::names());
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
