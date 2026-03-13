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
        Schema::create('departure_schedules', function (Blueprint $table) {
            $table->id('schedule_id');
            $table->unsignedBigInteger('tour_id');
            $table->date('departure_date');
            $table->date('end_date')->nullable();
            $table->integer('capacity');
            $table->integer('booked')->default(0);
            $table->decimal('price', 15, 2)->nullable();
            $table->enum('status', ['open', 'closed', 'cancelled'])->default('open');
            $table->text('note')->nullable();
            $table->timestamps();

            $table->unique(['tour_id', 'departure_date'], 'uniq_tour_departure_date');
            $table->index(['tour_id', 'departure_date'], 'idx_tour_departure_date');

            // Không tạo foreign key để tránh lỗi khi bảng `tour` không được tạo bởi migrations.
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('departure_schedules');
    }
};

