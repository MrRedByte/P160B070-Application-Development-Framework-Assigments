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
        Schema::create('policies', function (Blueprint $table) {
            $table->id();
            $table->string('policy_number')->unique();
            $table->foreignId('owner_id')->constrained()->cascadeOnDelete();
            $table->foreignId('car_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained(); // Agent who created the policy
            $table->date('start_date');
            $table->date('end_date');
            $table->string('status')->default('pending'); // pending, active, expired, cancelled
            $table->decimal('total_premium', 10, 2)->default(0);
            $table->string('payment_frequency')->default('monthly'); // monthly, quarterly, annually
            $table->decimal('deductible', 10, 2)->default(0);
            $table->text('terms_and_conditions')->nullable();
            $table->text('notes')->nullable();
            $table->timestamp('activated_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->string('cancellation_reason')->nullable();
            $table->softDeletes();
            $table->timestamps();
            
            $table->index(['status', 'end_date']);
            $table->index(['owner_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('policies');
    }
};
