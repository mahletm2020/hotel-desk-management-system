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
        Schema::create('stays', function (Blueprint $table) {
            $table->id();

            $table->foreignId('guest_id')
            ->constrained()
            ->cascadeOnDelete();

            $table->foreignId('reservation_id')
            ->nullable()
            ->constrained()
            ->nullOnDelete();

            $table->dateTime('check_in_date');
            $table->dateTime('check_out_date');

            $table->enum('status', [
                'active',
                'checked_out',
                'cancelled'
            ])->default('active');

            $table->decimal('total_price', 10, 2)->default(0);
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
        Schema::dropIfExists('stays');
    }
};
