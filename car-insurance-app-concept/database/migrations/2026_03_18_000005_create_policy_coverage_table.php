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
        Schema::create('policy_coverage', function (Blueprint $table) {
            $table->id();
            $table->foreignId('policy_id')->constrained()->cascadeOnDelete();
            $table->foreignId('coverage_type_id')->constrained()->cascadeOnDelete();
            $table->decimal('coverage_limit', 12, 2)->default(0);
            $table->decimal('deductible', 10, 2)->default(0);
            $table->decimal('premium_amount', 10, 2)->default(0);
            $table->json('options')->nullable(); // Additional coverage options
            $table->timestamps();
            
            $table->unique(['policy_id', 'coverage_type_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('policy_coverage');
    }
};
