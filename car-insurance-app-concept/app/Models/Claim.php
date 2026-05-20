<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Claim extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'claim_number',
        'policy_id',
        'driver_id',
        'user_id',
        'incident_date',
        'description',
        'location',
        'police_report_number',
        'damage_amount',
        'estimated_payout',
        'actual_payout',
        'status',
        'adjuster_notes',
        'assigned_adjuster',
        'filed_date',
        'reviewed_date',
        'approved_date',
        'denied_date',
        'paid_date',
        'denial_reason',
        'evidence',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'incident_date' => 'datetime',
        'damage_amount' => 'decimal:2',
        'estimated_payout' => 'decimal:2',
        'actual_payout' => 'decimal:2',
        'filed_date' => 'date',
        'reviewed_date' => 'date',
        'approved_date' => 'date',
        'denied_date' => 'date',
        'paid_date' => 'date',
        'evidence' => 'array',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($claim) {
            if (!$claim->claim_number) {
                $claim->claim_number = static::generateClaimNumber();
            }
            if (!$claim->filed_date) {
                $claim->filed_date = now();
            }
        });
    }

    /**
     * Generate a unique claim number.
     */
    public static function generateClaimNumber(): string
    {
        $year = date('Y');
        $random = strtoupper(Str::random(6));
        return "CLM-{$year}-{$random}";
    }

    /**
     * Scope a query to only include claims with specific status.
     */
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope a query to only include filed claims.
     */
    public function scopeFiled($query)
    {
        return $query->where('status', 'filed');
    }

    /**
     * Scope a query to only include approved claims.
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * Scope a query to search claims by number.
     */
    public function scopeSearch($query, $search)
    {
        return $query->where('claim_number', 'LIKE', "%{$search}%");
    }

    /**
     * Get the policy associated with this claim.
     */
    public function policy()
    {
        return $this->belongsTo(Policy::class);
    }

    /**
     * Get the driver associated with this claim.
     */
    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    /**
     * Get the agent handling this claim.
     */
    public function agent()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Check if the claim is approved.
     */
    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    /**
     * Check if the claim is paid.
     */
    public function isPaid(): bool
    {
        return $this->status === 'paid';
    }

    /**
     * Check if the claim is denied.
     */
    public function isDenied(): bool
    {
        return $this->status === 'denied';
    }

    /**
     * Approve the claim.
     */
    public function approve(float $payoutAmount): void
    {
        $this->update([
            'status' => 'approved',
            'approved_date' => now(),
            'actual_payout' => $payoutAmount,
        ]);
    }

    /**
     * Deny the claim.
     */
    public function deny(string $reason): void
    {
        $this->update([
            'status' => 'denied',
            'denied_date' => now(),
            'denial_reason' => $reason,
        ]);
    }

    /**
     * Mark the claim as paid.
     */
    public function markAsPaid(): void
    {
        $this->update([
            'status' => 'paid',
            'paid_date' => now(),
        ]);
    }

    /**
     * Get the status badge class.
     */
    public function getStatusBadgeClassAttribute(): string
    {
        $classes = [
            'filed' => 'bg-warning',
            'investigating' => 'bg-info',
            'approved' => 'bg-success',
            'denied' => 'bg-danger',
            'paid' => 'bg-success',
        ];
        
        return $classes[$this->status] ?? 'bg-secondary';
    }
}
