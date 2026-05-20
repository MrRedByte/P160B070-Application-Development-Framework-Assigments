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
        Schema::create('drivers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('owner_id')->constrained()->cascadeOnDelete();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('license_number');
            $table->string('license_state')->nullable();
            $table->string('license_country')->default('US');
            $table->date('date_of_birth');
            $table->date('license_expiry');
            $table->boolean('is_primary')->default(false);
            $table->integer('violations_count')->default(0);
            $table->text('notes')->nullable();
            $table->softDeletes();
            $table->timestamps();
            
            $table->index(['owner_id', 'is_primary']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('drivers');
    }
};
