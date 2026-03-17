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
        Schema::create('stay_rooms', function (Blueprint $table) {
            $table->id();

            $table->foreignId('stay_id')
            ->constrained()
            ->cascadeOnDelete();

            $table->foreignId('room_id')
            ->constrained()
            ->cascadeOnDelete();

            $table->decimal('price_per_night', 10, 2);

            $table->dateTime('check_in');
            $table->dateTime('check_out')->nullable();
            
            $table->timestamps();

            $table->unique(['stay_id', 'room_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stay_rooms');
    }
};
