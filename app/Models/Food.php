<?php
// app/Models/Food.php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Food extends Model {
    use SoftDeletes;

     protected $table = 'foods'; 

    protected $fillable = [
        'category_id', 'name', 'slug', 'description', 'price', 'discount_price',
        'image', 'images', 'cuisine', 'spicy_level', 'ingredients', 'allergens',
        'calories', 'prep_time', 'is_vegetarian', 'is_vegan', 'is_halal',
        'is_featured', 'is_available', 'is_popular', 'rating', 'rating_count',
        'total_orders', 'add_ons', 'sizes'
    ];
    protected $casts = [
        'images' => 'array', 'ingredients' => 'array', 'allergens' => 'array',
        'add_ons' => 'array', 'sizes' => 'array', 'is_vegetarian' => 'boolean',
        'is_vegan' => 'boolean', 'is_halal' => 'boolean', 'is_featured' => 'boolean',
        'is_available' => 'boolean', 'is_popular' => 'boolean',
        'price' => 'decimal:2', 'discount_price' => 'decimal:2', 'rating' => 'decimal:2',
    ];
    public function category() { return $this->belongsTo(Category::class); }
    public function reviews() { return $this->hasMany(Review::class); }
    public function cartItems() { return $this->hasMany(Cart::class); }

    public function getEffectivePriceAttribute(): float {
        return $this->discount_price ?? $this->price;
    }
    public function getImageUrlAttribute(): string {
        return $this->image ?: 'https://images.unsplash.com/photo-1504674900247-0877df9cc836?w=500';
    }
    public function getSpicyIconAttribute(): string {
        return match($this->spicy_level) {
            'mild' => '🌶️', 'medium' => '🌶️🌶️', 'hot' => '🌶️🌶️🌶️', 'extra_hot' => '🌶️🌶️🌶️🌶️',
            default => '🌶️'
        };
    }
    public function getDiscountPercentageAttribute(): ?int {
        if ($this->discount_price && $this->price > 0) {
            return (int)(($this->price - $this->discount_price) / $this->price * 100);
        }
        return null;
    }
}
