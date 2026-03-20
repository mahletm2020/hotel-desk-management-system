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
            
            $table->foreignId('room_id')->nullable()->constrained();
            
            $table->foreignId('guest_id')
            ->constrained()
            ->cascadeOnDelete();


            // $table->foreignId('room_id')->constrained()->cascadeOnDelete();

            $table->date('check_in_date');
            $table->date('check_out_date');

            $table->decimal('total_price', 10, 2)->nullable();
            $table->enum('status', [
                'pending',
                'confirmed',
                'checked_in',
                'checked_out',
                'cancelled'
            ])->default('pending');

            $table->text('notes')->nullable();

            $table->timestamps();

            $table->index('check_in_date');
            $table->index('check_out_date');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
