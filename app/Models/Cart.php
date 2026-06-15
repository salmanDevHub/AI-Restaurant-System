<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = [
        'user_id','food_id','quantity',
        'add_ons','size','special_instructions'
    ];

    protected $casts = ['add_ons' => 'array'];

    public function food() { return $this->belongsTo(Food::class); }
    public function user() { return $this->belongsTo(User::class); }

    public function getItemTotalAttribute(): float
    {
        $price      = $this->food->effective_price;
        $addonsTotal = collect($this->add_ons ?? [])->sum('price');
        return ($price + $addonsTotal) * $this->quantity;
    }
}
