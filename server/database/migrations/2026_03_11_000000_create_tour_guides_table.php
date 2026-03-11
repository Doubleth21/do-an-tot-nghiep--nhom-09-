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
        Schema::create('tour_guides', function (Blueprint $table) {
            // IMPORTANT: Kiểu dữ liệu phải khớp 100% với cột được tham chiếu.
            // Theo database SQL bạn gửi:
            // - tour.tour_id là INT (không UNSIGNED)
            // - users.user_id là INT (không UNSIGNED)
            // Vì vậy ở bảng pivot phải dùng integer() (không unsigned/bigint) để tránh lỗi 3780.
            $table->integer('tour_id');
            $table->integer('user_id');
            $table->dateTime('assigned_at')->nullable();

            $table->primary(['tour_id', 'user_id']);

            $table->foreign('tour_id')
                ->references('tour_id')
                ->on('tour')
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('user_id')
                ->on('users')
                ->onDelete('cascade');

            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tour_guides');
    }
};
