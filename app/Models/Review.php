<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'user_id','food_id','order_id',
        'rating','comment','images',
        'is_verified','is_visible'
    ];

    protected $casts = [
        'images'      => 'array',
        'is_verified' => 'boolean',
        'is_visible'  => 'boolean',
    ];

    public function user()  { return $this->belongsTo(User::class); }
    public function food()  { return $this->belongsTo(Food::class); }
    public function order() { return $this->belongsTo(Order::class); }
}
