<?php
// app/Models/User.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable {
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name', 'email', 'phone', 'password', 'role', 'avatar',
        'address', 'city', 'postal_code', 'email_verified', 'phone_verified',
        'email_verification_token', 'phone_otp', 'phone_otp_expires_at',
        'total_orders', 'total_spent', 'loyalty_tier', 'loyalty_points',
        'is_active', 'is_blocked', 'google_id',
    ];

    protected $hidden = ['password', 'remember_token', 'phone_otp', 'email_verification_token'];

    protected $casts = [
        'email_verified' => 'boolean',
        'phone_verified' => 'boolean',
        'is_active' => 'boolean',
        'is_blocked' => 'boolean',
        'phone_otp_expires_at' => 'datetime',
        'total_spent' => 'decimal:2',
        'loyalty_points' => 'integer',
    ];

    public function isAdmin(): bool { return $this->role === 'admin'; }
    public function isDelivery(): bool { return $this->role === 'delivery'; }
    public function isUser(): bool { return $this->role === 'user'; }

    public function orders() { return $this->hasMany(Order::class); }
    public function cart() { return $this->hasMany(Cart::class); }
    public function wishlists() { return $this->hasMany(Wishlist::class); }
    public function reviews() { return $this->hasMany(Review::class); }
    public function notifications() { return $this->hasMany(Notification::class); }
    public function aiConversations() { return $this->hasMany(AiConversation::class); }

    public function getLoyaltyTierColorAttribute(): string {
        return match($this->loyalty_tier) {
            'bronze' => '#CD7F32', 'silver' => '#C0C0C0',
            'gold' => '#FFD700', 'platinum' => '#E5E4E2',
            default => '#CD7F32'
        };
    }

    public function getDiscountPercentageAttribute(): int {
        return match($this->loyalty_tier) {
            'bronze' => 0, 'silver' => 5, 'gold' => 10, 'platinum' => 15,
            default => 0
        };
    }

    public function updateLoyaltyTier(): void {
        $tier = 'bronze';
        if ($this->total_orders >= 50 || $this->total_spent >= 50000) $tier = 'platinum';
        elseif ($this->total_orders >= 20 || $this->total_spent >= 20000) $tier = 'gold';
        elseif ($this->total_orders >= 5 || $this->total_spent >= 5000) $tier = 'silver';
        $this->update(['loyalty_tier' => $tier]);
    }

    public function getAvatarUrlAttribute(): string {
        if ($this->avatar) {
            return asset('storage/' . $this->avatar);
        }
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=FF6B35&color=fff';
    }
}
