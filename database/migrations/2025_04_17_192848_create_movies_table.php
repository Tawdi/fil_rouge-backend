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
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->integer('duration');
            $table->float('rating');
            $table->text('description');
            $table->date('release_date');
            $table->string('director')->nullable();
            $table->string('actors')->nullable();
            $table->text('poster')->nullable();
            $table->text('background')->nullable();
            $table->text('trailer')->nullable();
            $table->foreignId('genre_id')->constrained()->onDelete('set null');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movies');
    }
};
