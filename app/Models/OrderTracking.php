<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderTracking extends Model
{
    protected $fillable = ['order_id','status','message','lat','lng','tracked_at'];

    protected $casts = ['tracked_at' => 'datetime'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
