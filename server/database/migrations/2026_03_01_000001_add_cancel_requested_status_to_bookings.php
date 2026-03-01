<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // MySQL: change enum to include cancel_requested
        Schema::table('bookings', function (Blueprint $table) {
            // use raw statement because enum->change() sometimes fails depending on driver
            $allowed = "'pending','confirmed','cancel_requested','cancelled','completed'";
            DB::statement("ALTER TABLE `bookings` MODIFY `status` ENUM($allowed) NOT NULL DEFAULT 'pending';");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $allowed = "'pending','confirmed','cancelled','completed'";
            DB::statement("ALTER TABLE `bookings` MODIFY `status` ENUM($allowed) NOT NULL DEFAULT 'pending';");
        });
    }
};
