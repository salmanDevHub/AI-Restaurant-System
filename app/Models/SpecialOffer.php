<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SpecialOffer extends Model
{
    protected $fillable = [
        'title','description','banner_image',
        'discount_type','discount_value',
        'coupon_code','min_order_amount',
        'usage_limit','used_count',
        'applicable_to','applicable_ids','applicable_tier',
        'starts_at','ends_at','is_active'
    ];

    protected $casts = [
        'applicable_ids'   => 'array',
        'discount_value'   => 'decimal:2',
        'min_order_amount' => 'decimal:2',
        'starts_at'        => 'datetime',
        'ends_at'          => 'datetime',
        'is_active'        => 'boolean',
    ];

    public function isValid(float $amount, ?User $user = null): bool
    {
        if (!$this->is_active) return false;
        if (now()->lt($this->starts_at) || now()->gt($this->ends_at)) return false;
        if ($amount < $this->min_order_amount) return false;
        if ($this->usage_limit && $this->used_count >= $this->usage_limit) return false;
        if ($this->applicable_to === 'user_tier' && $user) {
            if ($user->loyalty_tier !== $this->applicable_tier) return false;
        }
        return true;
    }

    public function calculateDiscount(float $amount): float
    {
        return match ($this->discount_type) {
            'percentage' => round($amount * ($this->discount_value / 100), 2),
            'fixed'      => min((float)$this->discount_value, $amount),
            default      => 0.0,
        };
    }
}
