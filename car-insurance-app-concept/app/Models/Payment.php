<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'policy_id',
        'amount',
        'payment_date',
        'due_date',
        'status',
        'payment_method',
        'transaction_id',
        'reference_number',
        'notes',
        'late_fee',
        'is_recurring',
        'payment_number',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'amount' => 'decimal:2',
        'late_fee' => 'decimal:2',
        'payment_date' => 'date',
        'due_date' => 'date',
        'is_recurring' => 'boolean',
        'payment_number' => 'integer',
    ];

    /**
     * Scope a query to only include pending payments.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope a query to only include paid payments.
     */
    public function scopePaid($query)
    {
        return $query->where('status', 'paid');
    }

    /**
     * Scope a query to only include late payments.
     */
    public function scopeLate($query)
    {
        return $query->where('status', 'late');
    }

    /**
     * Scope a query to only include overdue payments.
     */
    public function scopeOverdue($query)
    {
        return $query->where('status', 'pending')
                    ->where('due_date', '<', now());
    }

    /**
     * Scope a query to only include payments due soon.
     */
    public function scopeDueSoon($query, $days = 7)
    {
        return $query->where('status', 'pending')
                    ->where('due_date', '>=', now())
                    ->where('due_date', '<=', now()->addDays($days));
    }

    /**
     * Get the policy associated with this payment.
     */
    public function policy()
    {
        return $this->belongsTo(Policy::class);
    }

    /**
     * Check if the payment is overdue.
     */
    public function isOverdue(): bool
    {
        return $this->status === 'pending' && $this->due_date < now();
    }

    /**
     * Check if the payment is due soon.
     */
    public function isDueSoon(int $days = 7): bool
    {
        return $this->status === 'pending' 
            && $this->due_date >= now()
            && $this->due_date <= now()->addDays($days);
    }

    /**
     * Check if the payment is paid.
     */
    public function isPaid(): bool
    {
        return $this->status === 'paid';
    }

    /**
     * Mark the payment as paid.
     */
    public function markAsPaid(string $transactionId = null): void
    {
        $this->update([
            'status' => 'paid',
            'payment_date' => now(),
            'transaction_id' => $transactionId ?? $this->transaction_id,
        ]);
    }

    /**
     * Mark the payment as late.
     */
    public function markAsLate(): void
    {
        $this->update([
            'status' => 'late',
        ]);
    }

    /**
     * Get the total amount due including late fees.
     */
    public function getTotalDueAttribute(): float
    {
        return $this->amount + $this->late_fee;
    }

    /**
     * Get the status badge class.
     */
    public function getStatusBadgeClassAttribute(): string
    {
        $classes = [
            'pending' => 'bg-warning',
            'paid' => 'bg-success',
            'late' => 'bg-danger',
            'failed' => 'bg-danger',
            'refunded' => 'bg-secondary',
        ];
        
        return $classes[$this->status] ?? 'bg-secondary';
    }
}
