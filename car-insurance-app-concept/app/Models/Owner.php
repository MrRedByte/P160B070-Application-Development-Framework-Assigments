<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Owner extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'surname',
        'email',
        'phone',
        'address',
        'date_of_birth',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date_of_birth' => 'date',
    ];

    /**
     * Get the owner's full name.
     */
    public function getFullNameAttribute(): string
    {
        return "{$this->name} {$this->surname}";
    }

    /**
     * Scope a query to only include owners with active policies.
     */
    public function scopeWithActivePolicies($query)
    {
        return $query->whereHas('policies', function ($q) {
            $q->where('status', 'active');
        });
    }

    /**
     * Scope a query to search owners by name or email.
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('name', 'LIKE', "%{$search}%")
              ->orWhere('surname', 'LIKE', "%{$search}%")
              ->orWhere('email', 'LIKE', "%{$search}%");
        });
    }

    /**
     * Get the cars owned by this owner.
     */
    public function cars()
    {
        return $this->hasMany(Car::class);
    }

    /**
     * Get the policies for this owner.
     */
    public function policies()
    {
        return $this->hasMany(Policy::class);
    }

    /**
     * Get the drivers associated with this owner.
     */
    public function drivers()
    {
        return $this->hasMany(Driver::class);
    }

    /**
     * Get the quotes for this owner.
     */
    public function quotes()
    {
        return $this->hasMany(Quote::class);
    }

    /**
     * Get the claims for this owner's policies.
     */
    public function claims()
    {
        return $this->hasManyThrough(Claim::class, Policy::class);
    }
}
