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
        Schema::create('seat_types',function (Blueprint $table){
            $table->id();
            $table->string('name'); 
        });

        // Schema::create('seats', function (Blueprint $table) {
        //     $table->id();
        //     $table->foreignId('seat_type_id')->constrained()->onDelete('cascade');
        //     $table->integer('number');
        //     $table->string('row'); // A,B,C ..
        //     $table->foreignId('room_id')->constrained()->onDelete('cascade');
        //     $table->timestamps();
        // });

        Schema::create('room_seat_type', function (Blueprint $table) {
            $table->id();
            $table->foreignId('room_id')->constrained()->onDelete('cascade');
            $table->foreignId('seat_type_id')->constrained()->onDelete('cascade');
            $table->decimal('price', 8, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seat_types');
        // Schema::dropIfExists('seats');
        Schema::dropIfExists('room_seat_type');
    }
};
