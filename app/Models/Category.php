<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Category extends Model {
    protected $fillable = ['name', 'slug', 'description', 'image', 'icon', 'cuisine_type', 'is_active', 'sort_order'];
    protected $casts = ['is_active' => 'boolean'];
    public function foods() { return $this->hasMany(Food::class); }
    public function activeFoods() { return $this->hasMany(Food::class)->where('is_available', true); }
    public function getImageUrlAttribute(): string {
        return $this->image ?: 'https://images.unsplash.com/photo-1504674900247-0877df9cc836?w=400';
    }
}
