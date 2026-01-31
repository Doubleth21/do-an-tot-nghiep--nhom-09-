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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id('booking_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('tour_id')->nullable();
            $table->integer('quantity'); // số lượng khách
            $table->decimal('total_price', 15, 2); // tổng giá
            $table->enum('status', ['pending', 'confirmed', 'cancelled', 'completed'])->default('pending');
            $table->text('notes')->nullable(); // ghi chú từ khách
            $table->timestamp('booking_date'); // ngày đặt
            $table->date('travel_date')->nullable(); // ngày khởi hành (nếu có)
            $table->timestamps();

            // Foreign keys - added with 'constrained' method if tables exist
            // Otherwise they will be added manually
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
