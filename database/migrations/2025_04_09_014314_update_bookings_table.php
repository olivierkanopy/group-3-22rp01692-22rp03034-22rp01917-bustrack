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
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['seat_number', 'total_price', 'payment_status', 'booking_reference']);
            $table->integer('seats')->after('schedule_id');
            $table->string('status')->default('pending')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->integer('seat_number')->after('schedule_id');
            $table->decimal('total_price', 8, 2)->after('seat_number');
            $table->string('payment_status')->after('status');
            $table->string('booking_reference')->after('payment_status');
            $table->enum('status', ['pending', 'confirmed', 'cancelled'])->change();
        });
    }
};
