<?php
// database/migrations/2024_01_01_000003_create_orders_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('delivery_person_id')->nullable()->references('id')->on('users');
            $table->json('items'); // [{food_id, name, price, qty, add_ons, size}]
            $table->decimal('subtotal', 10, 2);
            $table->decimal('delivery_fee', 8, 2)->default(0);
            $table->decimal('tax', 8, 2)->default(0);
            $table->decimal('discount', 8, 2)->default(0);
            $table->decimal('total', 10, 2);
            $table->string('coupon_code')->nullable();
            $table->enum('type', ['delivery', 'pickup', 'dine_in'])->default('delivery');
            $table->enum('status', [
                'pending', 'confirmed', 'preparing', 'ready',
                'picked_up', 'on_the_way', 'delivered', 'cancelled', 'refunded'
            ])->default('pending');
            $table->enum('payment_method', ['cash', 'card', 'online', 'wallet'])->default('cash');
            $table->enum('payment_status', ['pending', 'paid', 'failed', 'refunded'])->default('pending');
            $table->string('payment_transaction_id')->nullable();
            // Delivery address
            $table->string('delivery_name')->nullable();
            $table->string('delivery_phone')->nullable();
            $table->text('delivery_address')->nullable();
            $table->string('delivery_city')->nullable();
            $table->string('delivery_postal_code')->nullable();
            $table->decimal('delivery_lat', 10, 8)->nullable();
            $table->decimal('delivery_lng', 11, 8)->nullable();
            $table->text('special_instructions')->nullable();
            $table->timestamp('estimated_delivery_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->integer('loyalty_points_earned')->default(0);
            $table->integer('loyalty_points_used')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('order_tracking', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->enum('status', [
                'pending', 'confirmed', 'preparing', 'ready',
                'picked_up', 'on_the_way', 'delivered', 'cancelled'
            ]);
            $table->text('message')->nullable();
            $table->decimal('lat', 10, 8)->nullable();
            $table->decimal('lng', 11, 8)->nullable();
            $table->timestamp('tracked_at')->nullable();
            $table->timestamps();
        });

        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('food_id')->constrained('foods')->onDelete('cascade'); // ✅ Fixed
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->integer('rating'); // 1-5
            $table->text('comment')->nullable();
            $table->json('images')->nullable();
            $table->boolean('is_verified')->default(false);
            $table->boolean('is_visible')->default(true);
            $table->timestamps();
        });

        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('food_id')->constrained('foods')->onDelete('cascade'); // ✅ Fixed
            $table->integer('quantity')->default(1);
            $table->json('add_ons')->nullable();
            $table->string('size')->nullable();
            $table->text('special_instructions')->nullable();
            $table->timestamps();
        });

        Schema::create('wishlists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('food_id')->constrained('foods')->onDelete('cascade'); // ✅ Fixed
            $table->timestamps();
            $table->unique(['user_id', 'food_id']);
        });

        Schema::create('ai_conversations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('session_id');
            $table->json('messages'); // [{role, content, timestamp}]
            $table->string('detected_mood')->nullable();
            $table->string('detected_emoji')->nullable();
            $table->json('suggested_foods')->nullable();
            $table->timestamps();
        });

        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('message');
            $table->string('type'); // order_update, promotion, welcome, etc.
            $table->json('data')->nullable();
            $table->boolean('is_read')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('notifications');
        Schema::dropIfExists('ai_conversations');
        Schema::dropIfExists('wishlists');
        Schema::dropIfExists('carts');
        Schema::dropIfExists('reviews');
        Schema::dropIfExists('order_tracking');
        Schema::dropIfExists('orders');
    }
};