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
        Schema::create('quotes', function (Blueprint $table) {
            $table->id();
            $table->string('quote_number')->unique();
            $table->foreignId('owner_id')->constrained()->cascadeOnDelete();
            $table->foreignId('car_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete(); // Agent who created
            $table->decimal('estimated_premium', 10, 2)->default(0);
            $table->json('coverages'); // Selected coverage details
            $table->json('vehicle_details')->nullable(); // Snapshot of vehicle info
            $table->json('driver_details')->nullable(); // Snapshot of driver info
            $table->string('status')->default('pending'); // pending, converted, expired, declined
            $table->text('notes')->nullable();
            $table->timestamp('expires_at');
            $table->foreignId('converted_to_policy_id')->nullable()->constrained('policies')->nullOnDelete();
            $table->decimal('discount_amount', 10, 2)->default(0);
            $table->string('discount_reason')->nullable();
            $table->softDeletes();
            $table->timestamps();
            
            $table->index(['status', 'expires_at']);
            $table->index(['owner_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotes');
    }
};
