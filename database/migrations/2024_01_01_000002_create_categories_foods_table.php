<?php
// database/migrations/2024_01_01_000002_create_categories_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->string('icon', 10)->nullable(); // emoji
            $table->string('cuisine_type')->nullable(); // Pakistani, Chinese, Italian etc
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('foods', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description');
            $table->decimal('price', 8, 2);
            $table->decimal('discount_price', 8, 2)->nullable();
            $table->string('image')->nullable();
            $table->json('images')->nullable(); // multiple images
            $table->string('cuisine')->nullable(); // Pakistani, Chinese, Italian, Mexican, etc.
            $table->enum('spicy_level', ['mild', 'medium', 'hot', 'extra_hot'])->default('medium');
            $table->json('ingredients')->nullable();
            $table->json('allergens')->nullable();
            $table->integer('calories')->nullable();
            $table->integer('prep_time')->default(15); // minutes
            $table->boolean('is_vegetarian')->default(false);
            $table->boolean('is_vegan')->default(false);
            $table->boolean('is_halal')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_available')->default(true);
            $table->boolean('is_popular')->default(false);
            $table->decimal('rating', 3, 2)->default(0);
            $table->integer('rating_count')->default(0);
            $table->integer('total_orders')->default(0);
            $table->json('add_ons')->nullable(); // extra options
            $table->json('sizes')->nullable(); // S, M, L with prices
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('food_add_ons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('food_id')->constrained('foods')->onDelete('cascade'); // ✅ Fixed: 'foods' explicitly specified
            $table->string('name');
            $table->decimal('price', 8, 2)->default(0);
            $table->boolean('is_available')->default(true);
            $table->timestamps();
        });

        Schema::create('special_offers', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('banner_image')->nullable();
            $table->enum('discount_type', ['percentage', 'fixed', 'buy_one_get_one'])->default('percentage');
            $table->decimal('discount_value', 8, 2)->default(0);
            $table->string('coupon_code')->unique()->nullable();
            $table->decimal('min_order_amount', 8, 2)->default(0);
            $table->integer('usage_limit')->nullable();
            $table->integer('used_count')->default(0);
            $table->enum('applicable_to', ['all', 'category', 'food', 'user_tier'])->default('all');
            $table->json('applicable_ids')->nullable();
            $table->string('applicable_tier')->nullable(); // bronze, silver, gold, platinum
            $table->timestamp('starts_at')->nullable();
            $table->timestamp('ends_at')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('special_offers');
        Schema::dropIfExists('food_add_ons');
        Schema::dropIfExists('foods');
        Schema::dropIfExists('categories');
    }
};