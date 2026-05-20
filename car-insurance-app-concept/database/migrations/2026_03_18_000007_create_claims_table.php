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
        Schema::create('claims', function (Blueprint $table) {
            $table->id();
            $table->string('claim_number')->unique();
            $table->foreignId('policy_id')->constrained()->cascadeOnDelete();
            $table->foreignId('driver_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('user_id')->constrained(); // Agent handling the claim
            $table->dateTime('incident_date');
            $table->text('description');
            $table->string('location')->nullable();
            $table->string('police_report_number')->nullable();
            $table->decimal('damage_amount', 12, 2)->default(0);
            $table->decimal('estimated_payout', 12, 2)->default(0);
            $table->decimal('actual_payout', 12, 2)->default(0);
            $table->string('status')->default('filed'); // filed, investigating, approved, denied, paid
            $table->text('adjuster_notes')->nullable();
            $table->string('assigned_adjuster')->nullable();
            $table->date('filed_date');
            $table->date('reviewed_date')->nullable();
            $table->date('approved_date')->nullable();
            $table->date('denied_date')->nullable();
            $table->date('paid_date')->nullable();
            $table->text('denial_reason')->nullable();
            $table->json('evidence')->nullable(); // Photos, documents
            $table->softDeletes();
            $table->timestamps();
            
            $table->index(['status', 'filed_date']);
            $table->index(['policy_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('claims');
    }
};
