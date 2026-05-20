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
        Schema::create('coverage_types', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Liability, Comprehensive, Collision, etc.
            $table->text('description')->nullable();
            $table->decimal('base_premium', 10, 2)->default(0);
            $table->string('type')->default('percentage'); // percentage, fixed
            $table->boolean('is_active')->default(true);
            $table->boolean('is_mandatory')->default(false);
            $table->json('requirements')->nullable(); // JSON for flexible requirements
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coverage_types');
    }
};
