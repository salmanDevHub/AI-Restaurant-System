<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'order_number','user_id','delivery_person_id','items',
        'subtotal','delivery_fee','tax','discount','total',
        'coupon_code','type','status','payment_method','payment_status',
        'payment_transaction_id','delivery_name','delivery_phone',
        'delivery_address','delivery_city','delivery_postal_code',
        'delivery_lat','delivery_lng','special_instructions',
        'estimated_delivery_at','delivered_at',
        'loyalty_points_earned','loyalty_points_used'
    ];

    protected $casts = [
        'items'                 => 'array',
        'subtotal'              => 'decimal:2',
        'delivery_fee'          => 'decimal:2',
        'tax'                   => 'decimal:2',
        'discount'              => 'decimal:2',
        'total'                 => 'decimal:2',
        'estimated_delivery_at' => 'datetime',
        'delivered_at'          => 'datetime',
    ];

    /* ── Relationships ── */
    public function user()           { return $this->belongsTo(User::class); }
    public function deliveryPerson() { return $this->belongsTo(User::class, 'delivery_person_id'); }
    public function tracking()       { return $this->hasMany(OrderTracking::class)->orderBy('tracked_at'); }
    public function reviews()        { return $this->hasMany(Review::class); }

    /* ── Helpers ── */
    public static function generateOrderNumber(): string
    {
        return 'FH-' . strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 8));
    }

    public function getStatusBadgeAttribute(): array
    {
        return match ($this->status) {
            'pending'    => ['color'=>'yellow',  'icon'=>'⏳', 'label'=>'Pending'],
            'confirmed'  => ['color'=>'blue',    'icon'=>'✅', 'label'=>'Confirmed'],
            'preparing'  => ['color'=>'orange',  'icon'=>'👨‍🍳','label'=>'Preparing'],
            'ready'      => ['color'=>'purple',  'icon'=>'📦', 'label'=>'Ready'],
            'picked_up'  => ['color'=>'indigo',  'icon'=>'🛵', 'label'=>'Picked Up'],
            'on_the_way' => ['color'=>'cyan',    'icon'=>'🚴', 'label'=>'On the Way'],
            'delivered'  => ['color'=>'green',   'icon'=>'🎉', 'label'=>'Delivered'],
            'cancelled'  => ['color'=>'red',     'icon'=>'❌', 'label'=>'Cancelled'],
            'refunded'   => ['color'=>'gray',    'icon'=>'↩️', 'label'=>'Refunded'],
            default      => ['color'=>'gray',    'icon'=>'❓', 'label'=>'Unknown'],
        };
    }
}
