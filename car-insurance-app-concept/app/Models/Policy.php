<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Policy extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'policy_number',
        'owner_id',
        'car_id',
        'user_id',
        'start_date',
        'end_date',
        'status',
        'total_premium',
        'payment_frequency',
        'deductible',
        'terms_and_conditions',
        'notes',
        'activated_at',
        'cancelled_at',
        'cancellation_reason',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'total_premium' => 'decimal:2',
        'deductible' => 'decimal:2',
        'activated_at' => 'datetime',
        'cancelled_at' => 'datetime',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($policy) {
            if (!$policy->policy_number) {
                $policy->policy_number = static::generatePolicyNumber();
            }
        });
    }

    /**
     * Generate a unique policy number.
     */
    public static function generatePolicyNumber(): string
    {
        $year = date('Y');
        $random = strtoupper(Str::random(6));
        return "POL-{$year}-{$random}";
    }

    /**
     * Scope a query to only include active policies.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope a query to only include expired policies.
     */
    public function scopeExpired($query)
    {
        return $query->where('status', 'expired');
    }

    /**
     * Scope a query to only include policies expiring soon.
     */
    public function scopeExpiringSoon($query, $days = 30)
    {
        return $query->where('status', 'active')
                    ->where('end_date', '<=', now()->addDays($days));
    }

    /**
     * Scope a query to search policies by number.
     */
    public function scopeSearch($query, $search)
    {
        return $query->where('policy_number', 'LIKE', "%{$search}%");
    }

    /**
     * Get the owner of the policy.
     */
    public function owner()
    {
        return $this->belongsTo(Owner::class);
    }

    /**
     * Get the car covered by this policy.
     */
    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    /**
     * Get the agent who created the policy.
     */
    public function agent()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the coverages for this policy.
     */
    public function coverages()
    {
        return $this->belongsToMany(CoverageType::class, 'policy_coverage')
                    ->withPivot('coverage_limit', 'deductible', 'premium_amount', 'options')
                    ->withTimestamps();
    }

    /**
     * Get the claims for this policy.
     */
    public function claims()
    {
        return $this->hasMany(Claim::class);
    }

    /**
     * Get the payments for this policy.
     */
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Check if the policy is currently active.
     */
    public function isActive(): bool
    {
        return $this->status === 'active' 
            && $this->start_date <= now() 
            && $this->end_date >= now();
    }

    /**
     * Check if the policy is expired.
     */
    public function isExpired(): bool
    {
        return $this->end_date < now();
    }

    /**
     * Check if the policy is expiring soon.
     */
    public function isExpiringSoon(int $days = 30): bool
    {
        return $this->status === 'active' 
            && $this->end_date <= now()->addDays($days)
            && $this->end_date > now();
    }

    /**
     * Get days until expiration.
     */
    public function daysUntilExpiration(): int
    {
        return max(0, now()->diffInDays($this->end_date, false));
    }

    /**
     * Activate the policy.
     */
    public function activate(): void
    {
        $this->update([
            'status' => 'active',
            'activated_at' => now(),
        ]);
    }

    /**
     * Cancel the policy.
     */
    public function cancel(string $reason): void
    {
        $this->update([
            'status' => 'cancelled',
            'cancelled_at' => now(),
            'cancellation_reason' => $reason,
        ]);
    }

    /**
     * Calculate the total premium with all coverages.
     */
    public function calculateTotalPremium(): float
    {
        return $this->coverages->sum(function ($coverage) {
            return $coverage->pivot->premium_amount;
        });
    }

    /**
     * Get the quote that was converted to this policy.
     */
    public function quote()
    {
        return $this->hasOne(Quote::class, 'converted_to_policy_id');
    }
}
