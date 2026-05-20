<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Car extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'reg_number',
        'vin',
        'brand',
        'model',
        'year',
        'color',
        'vehicle_type',
        'mileage',
        'owner_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'year' => 'integer',
        'mileage' => 'integer',
    ];

    /**
     * Get the full vehicle description.
     */
    public function getFullDescriptionAttribute(): string
    {
        $year = $this->year ? "{$this->year} " : '';
        return "{$year}{$this->brand} {$this->model}";
    }

    /**
     * Get the vehicle type badge class.
     */
    public function getVehicleTypeBadgeClassAttribute(): string
    {
        $types = [
            'sedan' => 'bg-info',
            'suv' => 'bg-primary',
            'hatchback' => 'bg-success',
            'coupe' => 'bg-warning',
            'convertible' => 'bg-danger',
            'wagon' => 'bg-secondary',
            'truck' => 'bg-dark',
            'van' => 'bg-info',
            'motorcycle' => 'bg-warning',
        ];
        
        return $types[$this->vehicle_type] ?? 'bg-secondary';
    }

    /**
     * Scope a query to search cars by registration, brand, model, or VIN.
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('reg_number', 'LIKE', "%{$search}%")
              ->orWhere('vin', 'LIKE', "%{$search}%")
              ->orWhere('brand', 'LIKE', "%{$search}%")
              ->orWhere('model', 'LIKE', "%{$search}%");
        });
    }

    /**
     * Scope a query to only include cars of a specific type.
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('vehicle_type', $type);
    }

    /**
     * Scope a query to only include cars within a year range.
     */
    public function scopeYearRange($query, $minYear, $maxYear)
    {
        return $query->whereBetween('year', [$minYear, $maxYear]);
    }

    /**
     * Get the owner of the car.
     */
    public function owner()
    {
        return $this->belongsTo(Owner::class);
    }

    /**
     * Get the policies for this car.
     */
    public function policies()
    {
        return $this->hasMany(Policy::class);
    }

    /**
     * Get the quotes for this car.
     */
    public function quotes()
    {
        return $this->hasMany(Quote::class);
    }

    /**
     * Get the claims for this car's policies.
     */
    public function claims()
    {
        return $this->hasManyThrough(Claim::class, Policy::class);
    }

    /**
     * Check if the car has active insurance.
     */
    public function hasActiveInsurance(): bool
    {
        return $this->policies()->where('status', 'active')->exists();
    }

    /**
     * Get the active policy for this car.
     */
    public function activePolicy()
    {
        return $this->policies()->where('status', 'active')->latest('start_date')->first();
    }
}
