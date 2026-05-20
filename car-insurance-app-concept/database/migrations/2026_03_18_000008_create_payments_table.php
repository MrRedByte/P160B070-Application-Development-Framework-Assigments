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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('policy_id')->constrained()->cascadeOnDelete();
            $table->decimal('amount', 10, 2);
            $table->date('payment_date');
            $table->date('due_date');
            $table->string('status')->default('pending'); // pending, paid, late, failed, refunded
            $table->string('payment_method')->nullable(); // card, bank_transfer, cash, check
            $table->string('transaction_id')->nullable();
            $table->string('reference_number')->nullable();
            $table->text('notes')->nullable();
            $table->decimal('late_fee', 10, 2)->default(0);
            $table->boolean('is_recurring')->default(false);
            $table->integer('payment_number')->default(1); // Payment number in the series
            $table->softDeletes();
            $table->timestamps();
            
            $table->index(['policy_id', 'status']);
            $table->index(['due_date', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
