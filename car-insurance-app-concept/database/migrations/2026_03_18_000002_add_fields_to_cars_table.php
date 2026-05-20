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
        Schema::table('cars', function (Blueprint $table) {
            $table->string('vin')->unique()->nullable()->after('reg_number');
            $table->integer('year')->nullable()->after('model');
            $table->string('color')->nullable()->after('year');
            $table->string('vehicle_type')->nullable()->after('color');
            $table->integer('mileage')->default(0)->after('vehicle_type');
            $table->softDeletes()->after('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cars', function (Blueprint $table) {
            $table->dropColumn(['vin', 'year', 'color', 'vehicle_type', 'mileage']);
            $table->dropSoftDeletes();
        });
    }
};
