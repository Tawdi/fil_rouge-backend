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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('set null');
            $table->foreignId('seance_id')->constrained('seances')->onDelete('cascade');
            $table->jsonb('seats'); 
            $table->timestamps();
        });

        // // Reservation_Seat (pivot)
        // Schema::create('reservation_seat', function (Blueprint $table) {
        //     $table->id();
        //     $table->foreignId('reservation_id')->constrained()->onDelete('cascade');
        //     $table->foreignId('seat_id')->constrained()->onDelete('cascade');
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
        // Schema::dropIfExists('reservation_seat');
    }
};
