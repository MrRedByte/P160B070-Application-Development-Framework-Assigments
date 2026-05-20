<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Quote extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'quote_number',
        'owner_id',
        'car_id',
        'user_id',
        'estimated_premium',
        'coverages',
        'vehicle_details',
        'driver_details',
        'status',
        'notes',
        'expires_at',
        'converted_to_policy_id',
        'discount_amount',
        'discount_reason',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'estimated_premium' => 'decimal:2',
        'coverages' => 'array',
        'vehicle_details' => 'array',
        'driver_details' => 'array',
        'expires_at' => 'datetime',
        'discount_amount' => 'decimal:2',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($quote) {
            if (!$quote->quote_number) {
                $quote->quote_number = static::generateQuoteNumber();
            }
            if (!$quote->expires_at) {
                $quote->expires_at = now()->addDays(30); // Quotes valid for 30 days
            }
        });
    }

    /**
     * Generate a unique quote number.
     */
    public static function generateQuoteNumber(): string
    {
        $year = date('Y');
        $random = strtoupper(Str::random(6));
        return "QT-{$year}-{$random}";
    }

    /**
     * Scope a query to only include pending quotes.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope a query to only include converted quotes.
     */
    public function scopeConverted($query)
    {
        return $query->where('status', 'converted');
    }

    /**
     * Scope a query to only include expired quotes.
     */
    public function scopeExpired($query)
    {
        return $query->where('expires_at', '<', now());
    }

    /**
     * Scope a query to only include quotes expiring soon.
     */
    public function scopeExpiringSoon($query, $days = 7)
    {
        return $query->where('status', 'pending')
                    ->where('expires_at', '<=', now()->addDays($days))
                    ->where('expires_at', '>=', now());
    }

    /**
     * Scope a query to search quotes by number.
     */
    public function scopeSearch($query, $search)
    {
        return $query->where('quote_number', 'LIKE', "%{$search}%");
    }

    /**
     * Get the owner associated with this quote.
     */
    public function owner()
    {
        return $this->belongsTo(Owner::class);
    }

    /**
     * Get the car for this quote.
     */
    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    /**
     * Get the agent who created the quote.
     */
    public function agent()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the policy this quote was converted to.
     */
    public function policy()
    {
        return $this->belongsTo(Policy::class, 'converted_to_policy_id');
    }

    /**
     * Check if the quote is expired.
     */
    public function isExpired(): bool
    {
        return $this->expires_at < now();
    }

    /**
     * Check if the quote is expiring soon.
     */
    public function isExpiringSoon(int $days = 7): bool
    {
        return $this->status === 'pending' 
            && $this->expires_at <= now()->addDays($days)
            && $this->expires_at > now();
    }

    /**
     * Check if the quote is converted.
     */
    public function isConverted(): bool
    {
        return $this->status === 'converted';
    }

    /**
     * Convert the quote to a policy.
     */
    public function convertToPolicy(array $policyData = []): Policy
    {
        return $this->connection->transaction(function () use ($policyData) {
            // Create the policy
            $policy = Policy::create(array_merge([
                'owner_id' => $this->owner_id,
                'car_id' => $this->car_id,
                'user_id' => $this->user_id,
                'start_date' => now(),
                'end_date' => now()->addYear(),
                'status' => 'pending',
                'total_premium' => $this->estimated_premium,
            ], $policyData));

            // Update the quote
            $this->update([
                'status' => 'converted',
                'converted_to_policy_id' => $policy->id,
            ]);

            return $policy;
        });
    }

    /**
     * Get days until expiration.
     */
    public function daysUntilExpiration(): int
    {
        return max(0, now()->diffInDays($this->expires_at, false));
    }

    /**
     * Get the premium after discount.
     */
    public function getFinalPremiumAttribute(): float
    {
        return $this->estimated_premium - $this->discount_amount;
    }

    /**
     * Get the status badge class.
     */
    public function getStatusBadgeClassAttribute(): string
    {
        $classes = [
            'pending' => 'bg-warning',
            'converted' => 'bg-success',
            'expired' => 'bg-secondary',
            'declined' => 'bg-danger',
        ];
        
        return $classes[$this->status] ?? 'bg-secondary';
    }
}
