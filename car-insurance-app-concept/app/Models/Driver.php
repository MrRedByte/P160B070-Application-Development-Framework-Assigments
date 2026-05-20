<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Driver extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'owner_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'license_number',
        'license_state',
        'license_country',
        'date_of_birth',
        'license_expiry',
        'is_primary',
        'violations_count',
        'notes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date_of_birth' => 'date',
        'license_expiry' => 'date',
        'is_primary' => 'boolean',
        'violations_count' => 'integer',
    ];

    /**
     * Get the driver's full name.
     */
    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    /**
     * Get the driver's age.
     */
    public function getAgeAttribute(): int
    {
        return $this->date_of_birth->age;
    }

    /**
     * Check if the license is expired.
     */
    public function isLicenseExpired(): bool
    {
        return $this->license_expiry < now();
    }

    /**
     * Check if the license expires soon.
     */
    public function isLicenseExpiringSoon(int $days = 90): bool
    {
        return $this->license_expiry <= now()->addDays($days) 
            && $this->license_expiry > now();
    }

    /**
     * Scope a query to only include primary drivers.
     */
    public function scopePrimary($query)
    {
        return $query->where('is_primary', true);
    }

    /**
     * Scope a query to search drivers by name or license.
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('first_name', 'LIKE', "%{$search}%")
              ->orWhere('last_name', 'LIKE', "%{$search}%")
              ->orWhere('license_number', 'LIKE', "%{$search}%")
              ->orWhere('email', 'LIKE', "%{$search}%");
        });
    }

    /**
     * Get the owner associated with this driver.
     */
    public function owner()
    {
        return $this->belongsTo(Owner::class);
    }

    /**
     * Get the claims for this driver.
     */
    public function claims()
    {
        return $this->hasMany(Claim::class);
    }
}
