<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoverageType extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'base_premium',
        'type',
        'is_active',
        'is_mandatory',
        'requirements',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'base_premium' => 'decimal:2',
        'is_active' => 'boolean',
        'is_mandatory' => 'boolean',
        'requirements' => 'array',
    ];

    /**
     * Scope a query to only include active coverage types.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to only include mandatory coverage types.
     */
    public function scopeMandatory($query)
    {
        return $query->where('is_mandatory', true);
    }

    /**
     * Get the policies that have this coverage.
     */
    public function policies()
    {
        return $this->belongsToMany(Policy::class, 'policy_coverage')
                    ->withPivot('coverage_limit', 'deductible', 'premium_amount', 'options')
                    ->withTimestamps();
    }

    /**
     * Calculate premium for this coverage.
     */
    public function calculatePremium(array $factors = []): float
    {
        $base = $this->base_premium;
        
        // Apply factors based on coverage type
        if ($this->type === 'percentage') {
            // Percentage-based premium (e.g., percentage of car value)
            if (isset($factors['vehicle_value'])) {
                $base = ($factors['vehicle_value'] * $this->base_premium) / 100;
            }
        }
        
        // Apply driver age factor
        if (isset($factors['driver_age']) && $factors['driver_age'] < 25) {
            $base *= 1.2; // 20% surcharge for young drivers
        }
        
        // Apply vehicle age factor
        if (isset($factors['vehicle_age']) && $factors['vehicle_age'] > 10) {
            $base *= 1.15; // 15% surcharge for older vehicles
        }
        
        return round($base, 2);
    }
}
