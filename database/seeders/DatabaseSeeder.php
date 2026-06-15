<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Category;
use App\Models\Food;

class DatabaseSeeder extends Seeder {
    public function run(): void {

        // ── USERS ──
        User::create(['name'=>'Admin Shajahan','email'=>'admin@shahjan.com','phone'=>'03001234567','password'=>Hash::make('admin123'),'role'=>'admin','email_verified'=>true,'phone_verified'=>true,'is_active'=>true]);
        User::create(['name'=>'Salman Khan','email'=>'user@shahjan.com','phone'=>'03009876543','password'=>Hash::make('user123'),'role'=>'user','email_verified'=>true,'phone_verified'=>true,'is_active'=>true,'total_orders'=>15,'total_spent'=>12500,'loyalty_tier'=>'silver','loyalty_points'=>450]);

        // ── CATEGORIES ──
        $cats = [
            ['name'=>'Pakistani Cuisine','slug'=>'pakistani-cuisine','icon'=>'🍛','sort_order'=>1,
             'image'=>'https://images.unsplash.com/photo-1631515243349-e0cb75fb8d3a?w=200'],
            ['name'=>'Tandoori Specials','slug'=>'tandoori-specials','icon'=>'🔥','sort_order'=>2,
             'image'=>'https://images.unsplash.com/photo-1599487488170-d11ec9c172f0?w=200'],
            ['name'=>'Burgers & Fast Food','slug'=>'burgers-fast-food','icon'=>'🍔','sort_order'=>3,
             'image'=>'https://images.unsplash.com/photo-1568901346375-23c9450c58cd?w=200'],
            ['name'=>'BBQ & Grill','slug'=>'bbq-grill','icon'=>'🥩','sort_order'=>4,
             'image'=>'https://images.unsplash.com/photo-1544025162-d76694265947?w=200'],
            ['name'=>'Chinese Food','slug'=>'chinese-food','icon'=>'🥢','sort_order'=>5,
             'image'=>'https://images.unsplash.com/photo-1563245372-f21724e3856d?w=200'],
            ['name'=>'Italian Pizza','slug'=>'italian-pizza','icon'=>'🍕','sort_order'=>6,
             'image'=>'https://images.unsplash.com/photo-1565299624946-b28f40a0ae38?w=200'],
            ['name'=>'Desserts & Sweets','slug'=>'desserts-sweets','icon'=>'🍰','sort_order'=>7,
             'image'=>'https://images.unsplash.com/photo-1551024506-0bccd828d307?w=200'],
            ['name'=>'Drinks & Beverages','slug'=>'drinks-beverages','icon'=>'🥤','sort_order'=>8,
             'image'=>'https://images.unsplash.com/photo-1551538827-9c037cb4f32a?w=200'],
            ['name'=>'Seafood','slug'=>'seafood','icon'=>'🦐','sort_order'=>9,
             'image'=>'https://images.unsplash.com/photo-1559847844-5315695dadae?w=200'],
            ['name'=>'Breakfast','slug'=>'breakfast','icon'=>'🍳','sort_order'=>10,
             'image'=>'https://images.unsplash.com/photo-1533089860892-a7c6f0a88666?w=200'],
            ['name'=>'Mexican Food','slug'=>'mexican-food','icon'=>'🌮','sort_order'=>11,
             'image'=>'https://images.unsplash.com/photo-1565299507177-b0ac66763828?w=200'],
            ['name'=>'Soups & Salads','slug'=>'soups-salads','icon'=>'🥗','sort_order'=>12,
             'image'=>'https://images.unsplash.com/photo-1547592166-23ac45744acd?w=200'],
        ];
        foreach($cats as $c) {
            Category::create(array_merge($c,['description'=>$c['name'].' - finest selection','is_active'=>true]));
        }

        $getCat = fn($slug) => Category::where('slug',$slug)->first()->id;

        // ── FOODS ──
        $foods = [
            // PAKISTANI
            ['category_id'=>$getCat('pakistani-cuisine'),'name'=>'Chicken Biryani','slug'=>'chicken-biryani','description'=>'Aromatic basmati rice slow-cooked with tender chicken, saffron, and whole spices. Multan ka mashoor biryani.','price'=>450,'discount_price'=>380,'image'=>'https://images.unsplash.com/photo-1631515243349-e0cb75fb8d3a?w=600','cuisine'=>'Pakistani','spicy_level'=>'medium','calories'=>650,'prep_time'=>35,'is_halal'=>true,'is_popular'=>true,'is_featured'=>true,'rating'=>4.8,'total_orders'=>520],
            ['category_id'=>$getCat('pakistani-cuisine'),'name'=>'Mutton Karahi','slug'=>'mutton-karahi','description'=>'Slow-cooked tender mutton in a rich tomato and spice base. Served fresh from the wok.','price'=>850,'image'=>'https://images.unsplash.com/photo-1585937421612-70a008356fbe?w=600','cuisine'=>'Pakistani','spicy_level'=>'hot','calories'=>720,'prep_time'=>45,'is_halal'=>true,'is_popular'=>true,'rating'=>4.9,'total_orders'=>380],
            ['category_id'=>$getCat('pakistani-cuisine'),'name'=>'Chicken Nihari','slug'=>'chicken-nihari','description'=>'Slow-cooked overnight chicken stew with aromatic spices. A true Mughal delicacy.','price'=>550,'image'=>'https://images.unsplash.com/photo-1574894709920-11b28e7367e3?w=600','cuisine'=>'Pakistani','spicy_level'=>'hot','calories'=>680,'prep_time'=>50,'is_halal'=>true,'is_popular'=>true,'rating'=>4.7,'total_orders'=>290],
            ['category_id'=>$getCat('pakistani-cuisine'),'name'=>'Dal Makhani','slug'=>'dal-makhani','description'=>'Creamy black lentils slow-cooked with butter, cream and spices. Comfort food at its finest.','price'=>320,'image'=>'https://images.unsplash.com/photo-1546833999-b9f581a1996d?w=600','cuisine'=>'Pakistani','spicy_level'=>'mild','calories'=>420,'prep_time'=>30,'is_halal'=>true,'is_vegetarian'=>true,'rating'=>4.5,'total_orders'=>210],
            ['category_id'=>$getCat('pakistani-cuisine'),'name'=>'Beef Pulao','slug'=>'beef-pulao','description'=>'Fragrant rice cooked with juicy beef pieces, whole spices, and fried onions.','price'=>480,'discount_price'=>400,'image'=>'https://images.unsplash.com/photo-1563379091339-03b21ab4a4f8?w=600','cuisine'=>'Pakistani','spicy_level'=>'medium','calories'=>580,'prep_time'=>40,'is_halal'=>true,'rating'=>4.6,'total_orders'=>175],

            // TANDOORI
            ['category_id'=>$getCat('tandoori-specials'),'name'=>'Chicken Tikka','slug'=>'chicken-tikka','description'=>'Juicy chicken marinated in yogurt and spices, char-grilled in our 480°C clay tandoor.','price'=>380,'image'=>'https://images.unsplash.com/photo-1599487488170-d11ec9c172f0?w=600','cuisine'=>'Tandoori','spicy_level'=>'medium','calories'=>420,'prep_time'=>25,'is_halal'=>true,'is_popular'=>true,'is_featured'=>true,'rating'=>4.9,'total_orders'=>680],
            ['category_id'=>$getCat('tandoori-specials'),'name'=>'Seekh Kabab','slug'=>'seekh-kabab','description'=>'Spiced minced beef skewers grilled over charcoal. Served with mint chutney and naan.','price'=>420,'image'=>'https://images.unsplash.com/photo-1529543544282-ea669407fca3?w=600','cuisine'=>'Tandoori','spicy_level'=>'medium','calories'=>380,'prep_time'=>20,'is_halal'=>true,'is_popular'=>true,'rating'=>4.8,'total_orders'=>540],
            ['category_id'=>$getCat('tandoori-specials'),'name'=>'Tandoori Naan','slug'=>'tandoori-naan','description'=>'Freshly baked fluffy naan from our clay tandoor. Brushed with butter and garlic.','price'=>80,'image'=>'https://images.unsplash.com/photo-1574894709920-11b28e7367e3?w=600','cuisine'=>'Tandoori','spicy_level'=>'mild','calories'=>220,'prep_time'=>10,'is_halal'=>true,'is_vegetarian'=>true,'is_popular'=>true,'rating'=>4.7,'total_orders'=>890],
            ['category_id'=>$getCat('tandoori-specials'),'name'=>'Reshmi Kabab','slug'=>'reshmi-kabab','description'=>'Silky smooth chicken kababs with cream cheese and cardamom. Melt-in-mouth texture.','price'=>460,'discount_price'=>390,'image'=>'https://images.unsplash.com/photo-1606491956689-2ea866880c84?w=600','cuisine'=>'Tandoori','spicy_level'=>'mild','calories'=>400,'prep_time'=>25,'is_halal'=>true,'is_featured'=>true,'rating'=>4.8,'total_orders'=>320],
            ['category_id'=>$getCat('tandoori-specials'),'name'=>'Boti Kabab','slug'=>'boti-kabab','description'=>'Marinated lamb cubes on skewers, grilled to perfection with aromatic spices.','price'=>520,'image'=>'https://images.unsplash.com/photo-1603360946369-dc9bb6258143?w=600','cuisine'=>'Tandoori','spicy_level'=>'hot','calories'=>460,'prep_time'=>30,'is_halal'=>true,'rating'=>4.6,'total_orders'=>245],

            // BURGERS
            ['category_id'=>$getCat('burgers-fast-food'),'name'=>'Zinger Burger','slug'=>'zinger-burger','description'=>'Crispy fried chicken fillet with lettuce, mayo, and our secret zinger sauce. Legendary crunch.','price'=>350,'image'=>'https://images.unsplash.com/photo-1568901346375-23c9450c58cd?w=600','cuisine'=>'Fast Food','spicy_level'=>'medium','calories'=>580,'prep_time'=>12,'is_halal'=>true,'is_popular'=>true,'is_featured'=>true,'rating'=>4.7,'total_orders'=>720],
            ['category_id'=>$getCat('burgers-fast-food'),'name'=>'Double Smash Burger','slug'=>'double-smash-burger','description'=>'Two smashed beef patties with American cheese, caramelized onions, and special sauce.','price'=>480,'discount_price'=>420,'image'=>'https://images.unsplash.com/photo-1586190848861-99aa4a171e90?w=600','cuisine'=>'Fast Food','spicy_level'=>'mild','calories'=>720,'prep_time'=>15,'is_halal'=>true,'is_popular'=>true,'rating'=>4.8,'total_orders'=>465],
            ['category_id'=>$getCat('burgers-fast-food'),'name'=>'Crispy Chicken Wrap','slug'=>'crispy-chicken-wrap','description'=>'Crispy fried chicken with fresh veggies and garlic sauce wrapped in a soft tortilla.','price'=>280,'image'=>'https://images.unsplash.com/photo-1626700051175-6818013e1d4f?w=600','cuisine'=>'Fast Food','spicy_level'=>'mild','calories'=>480,'prep_time'=>10,'is_halal'=>true,'rating'=>4.5,'total_orders'=>310],
            ['category_id'=>$getCat('burgers-fast-food'),'name'=>'Loaded Cheese Fries','slug'=>'loaded-cheese-fries','description'=>'Golden crispy fries loaded with melted cheddar, jalapenos, and sour cream.','price'=>220,'image'=>'https://images.unsplash.com/photo-1573080496219-bb080dd4f877?w=600','cuisine'=>'Fast Food','spicy_level'=>'medium','calories'=>520,'prep_time'=>8,'is_vegetarian'=>true,'is_halal'=>true,'rating'=>4.6,'total_orders'=>580],
            ['category_id'=>$getCat('burgers-fast-food'),'name'=>'Chicken Shawarma','slug'=>'chicken-shawarma','description'=>'Lebanese-style chicken shawarma with garlic sauce, pickles and fresh vegetables.','price'=>260,'discount_price'=>220,'image'=>'https://images.unsplash.com/photo-1529543544282-ea669407fca3?w=600','cuisine'=>'Fast Food','spicy_level'=>'mild','calories'=>440,'prep_time'=>10,'is_halal'=>true,'is_popular'=>true,'rating'=>4.7,'total_orders'=>620],

            // BBQ
            ['category_id'=>$getCat('bbq-grill'),'name'=>'BBQ Platter','slug'=>'bbq-platter','description'=>'Mixed grill platter with seekh kabab, chicken tikka, boti, and lamb chops. Feast for two.','price'=>1200,'discount_price'=>980,'image'=>'https://images.unsplash.com/photo-1544025162-d76694265947?w=600','cuisine'=>'BBQ','spicy_level'=>'hot','calories'=>980,'prep_time'=>40,'is_halal'=>true,'is_popular'=>true,'is_featured'=>true,'rating'=>4.9,'total_orders'=>285],
            ['category_id'=>$getCat('bbq-grill'),'name'=>'Lamb Chops','slug'=>'lamb-chops','description'=>'Rack of tender lamb chops marinated in herbs and char-grilled over live charcoal.','price'=>850,'image'=>'https://images.unsplash.com/photo-1603360946369-dc9bb6258143?w=600','cuisine'=>'BBQ','spicy_level'=>'medium','calories'=>620,'prep_time'=>35,'is_halal'=>true,'is_featured'=>true,'rating'=>4.8,'total_orders'=>195],
            ['category_id'=>$getCat('bbq-grill'),'name'=>'Grilled Fish','slug'=>'grilled-fish','description'=>'Whole fish marinated in spices and char-grilled. Served with chutney and salad.','price'=>650,'image'=>'https://images.unsplash.com/photo-1559847844-5315695dadae?w=600','cuisine'=>'BBQ','spicy_level'=>'medium','calories'=>380,'prep_time'=>30,'is_halal'=>true,'rating'=>4.5,'total_orders'=>165],
            ['category_id'=>$getCat('bbq-grill'),'name'=>'Shish Tawook','slug'=>'shish-tawook','description'=>'Lebanese marinated chicken cubes grilled on skewers with mixed peppers.','price'=>480,'image'=>'https://images.unsplash.com/photo-1529543544282-ea669407fca3?w=600','cuisine'=>'BBQ','spicy_level'=>'mild','calories'=>420,'prep_time'=>25,'is_halal'=>true,'rating'=>4.6,'total_orders'=>210],

            // CHINESE
            ['category_id'=>$getCat('chinese-food'),'name'=>'Kung Pao Chicken','slug'=>'kung-pao-chicken','description'=>'Stir-fried chicken with peanuts, vegetables, and dried chili in a savory sauce.','price'=>420,'image'=>'https://images.unsplash.com/photo-1563245372-f21724e3856d?w=600','cuisine'=>'Chinese','spicy_level'=>'hot','calories'=>480,'prep_time'=>20,'is_halal'=>true,'is_popular'=>true,'rating'=>4.7,'total_orders'=>345],
            ['category_id'=>$getCat('chinese-food'),'name'=>'Beef Chow Mein','slug'=>'beef-chow-mein','description'=>'Stir-fried egg noodles with tender beef strips, vegetables in soy and oyster sauce.','price'=>380,'discount_price'=>320,'image'=>'https://images.unsplash.com/photo-1569718212165-3a8278d5f624?w=600','cuisine'=>'Chinese','spicy_level'=>'mild','calories'=>520,'prep_time'=>18,'is_halal'=>true,'is_popular'=>true,'rating'=>4.6,'total_orders'=>420],
            ['category_id'=>$getCat('chinese-food'),'name'=>'Dim Sum Platter','slug'=>'dim-sum-platter','description'=>'Steamed dumplings filled with shrimp, pork, and vegetables. Served with dipping sauce.','price'=>450,'image'=>'https://images.unsplash.com/photo-1563245372-f21724e3856d?w=600','cuisine'=>'Chinese','spicy_level'=>'mild','calories'=>360,'prep_time'=>25,'is_halal'=>true,'rating'=>4.5,'total_orders'=>180],
            ['category_id'=>$getCat('chinese-food'),'name'=>'Fried Rice Special','slug'=>'fried-rice-special','description'=>'Wok-tossed rice with eggs, vegetables, and your choice of chicken or beef.','price'=>320,'image'=>'https://images.unsplash.com/photo-1603360946369-dc9bb6258143?w=600','cuisine'=>'Chinese','spicy_level'=>'mild','calories'=>480,'prep_time'=>15,'is_halal'=>true,'rating'=>4.4,'total_orders'=>390],

            // PIZZA
            ['category_id'=>$getCat('italian-pizza'),'name'=>'Margherita Pizza','slug'=>'margherita-pizza','description'=>'Classic Neapolitan pizza with San Marzano tomato, fresh mozzarella, and basil leaves.','price'=>580,'discount_price'=>480,'image'=>'https://images.unsplash.com/photo-1565299624946-b28f40a0ae38?w=600','cuisine'=>'Italian','spicy_level'=>'mild','calories'=>620,'prep_time'=>20,'is_vegetarian'=>true,'is_halal'=>true,'is_popular'=>true,'rating'=>4.7,'total_orders'=>510],
            ['category_id'=>$getCat('italian-pizza'),'name'=>'BBQ Chicken Pizza','slug'=>'bbq-chicken-pizza','description'=>'Smoky BBQ base with grilled chicken, red onions, and mozzarella on thin crust.','price'=>680,'image'=>'https://images.unsplash.com/photo-1513104890138-7c749659a591?w=600','cuisine'=>'Italian','spicy_level'=>'mild','calories'=>720,'prep_time'=>22,'is_halal'=>true,'is_popular'=>true,'rating'=>4.8,'total_orders'=>460],
            ['category_id'=>$getCat('italian-pizza'),'name'=>'Pepperoni Feast','slug'=>'pepperoni-feast','description'=>'Loaded with halal pepperoni, mozzarella, and tomato sauce on hand-tossed dough.','price'=>720,'discount_price'=>620,'image'=>'https://images.unsplash.com/photo-1534308983496-4fabb1a015ee?w=600','cuisine'=>'Italian','spicy_level'=>'medium','calories'=>780,'prep_time'=>22,'is_halal'=>true,'rating'=>4.6,'total_orders'=>380],
            ['category_id'=>$getCat('italian-pizza'),'name'=>'Spaghetti Carbonara','slug'=>'spaghetti-carbonara','description'=>'Creamy pasta with eggs, pecorino, guanciale, and black pepper. Roman classic.','price'=>480,'image'=>'https://images.unsplash.com/photo-1612874742237-6526221588e3?w=600','cuisine'=>'Italian','spicy_level'=>'mild','calories'=>680,'prep_time'=>18,'is_halal'=>true,'rating'=>4.5,'total_orders'=>220],

            // DESSERTS
            ['category_id'=>$getCat('desserts-sweets'),'name'=>'Lava Cake','slug'=>'lava-cake','description'=>'Warm chocolate fondant with a molten center, served with vanilla ice cream.','price'=>280,'image'=>'https://images.unsplash.com/photo-1606313564200-e75d5e30476c?w=600','cuisine'=>'Desserts','spicy_level'=>'mild','calories'=>480,'prep_time'=>15,'is_vegetarian'=>true,'is_halal'=>true,'is_popular'=>true,'is_featured'=>true,'rating'=>4.9,'total_orders'=>620],
            ['category_id'=>$getCat('desserts-sweets'),'name'=>'Gulab Jamun','slug'=>'gulab-jamun','description'=>'Soft milk-solid dumplings soaked in rose-flavored sugar syrup. Pakistani classic.','price'=>180,'image'=>'https://images.unsplash.com/photo-1601303516534-bf4ab4b4e1fd?w=600','cuisine'=>'Desserts','spicy_level'=>'mild','calories'=>320,'prep_time'=>10,'is_vegetarian'=>true,'is_halal'=>true,'is_popular'=>true,'rating'=>4.8,'total_orders'=>540],
            ['category_id'=>$getCat('desserts-sweets'),'name'=>'Strawberry Cheesecake','slug'=>'strawberry-cheesecake','description'=>'Rich and creamy New York-style cheesecake with fresh strawberry compote on top.','price'=>320,'discount_price'=>280,'image'=>'https://images.unsplash.com/photo-1533134242443-d4fd215305ad?w=600','cuisine'=>'Desserts','spicy_level'=>'mild','calories'=>420,'prep_time'=>0,'is_vegetarian'=>true,'is_halal'=>true,'is_featured'=>true,'rating'=>4.8,'total_orders'=>380],
            ['category_id'=>$getCat('desserts-sweets'),'name'=>'Chocolate Brownie','slug'=>'chocolate-brownie','description'=>'Dense, fudgy chocolate brownie with walnuts, served warm with caramel drizzle.','price'=>220,'image'=>'https://images.unsplash.com/photo-1606313564200-e75d5e30476c?w=600','cuisine'=>'Desserts','spicy_level'=>'mild','calories'=>380,'prep_time'=>5,'is_vegetarian'=>true,'is_halal'=>true,'rating'=>4.7,'total_orders'=>295],
            ['category_id'=>$getCat('desserts-sweets'),'name'=>'Kheer','slug'=>'kheer','description'=>'Traditional Pakistani rice pudding with cardamom, saffron and topped with pistachios.','price'=>150,'image'=>'https://images.unsplash.com/photo-1601303516534-bf4ab4b4e1fd?w=600','cuisine'=>'Desserts','spicy_level'=>'mild','calories'=>280,'prep_time'=>0,'is_vegetarian'=>true,'is_halal'=>true,'rating'=>4.6,'total_orders'=>240],
            ['category_id'=>$getCat('desserts-sweets'),'name'=>'Cupcake Box (6pcs)','slug'=>'cupcake-box','description'=>'Assorted gourmet cupcakes with buttercream frosting. Perfect for celebrations.','price'=>480,'discount_price'=>420,'image'=>'https://images.unsplash.com/photo-1519869325930-281384150729?w=600','cuisine'=>'Desserts','spicy_level'=>'mild','calories'=>320,'prep_time'=>0,'is_vegetarian'=>true,'is_halal'=>true,'is_featured'=>true,'rating'=>4.7,'total_orders'=>185],
            ['category_id'=>$getCat('desserts-sweets'),'name'=>'Mango Kulfi','slug'=>'mango-kulfi','description'=>'Traditional Pakistani ice cream made with condensed milk and fresh mangoes.','price'=>160,'image'=>'https://images.unsplash.com/photo-1488900128323-21503983a07e?w=600','cuisine'=>'Desserts','spicy_level'=>'mild','calories'=>220,'prep_time'=>0,'is_vegetarian'=>true,'is_halal'=>true,'rating'=>4.8,'total_orders'=>420],
            ['category_id'=>$getCat('desserts-sweets'),'name'=>'Tiramisu','slug'=>'tiramisu','description'=>'Classic Italian dessert with espresso-soaked ladyfingers and mascarpone cream.','price'=>340,'image'=>'https://images.unsplash.com/photo-1571877227200-a0d98ea607e9?w=600','cuisine'=>'Desserts','spicy_level'=>'mild','calories'=>380,'prep_time'=>0,'is_vegetarian'=>true,'is_halal'=>true,'is_featured'=>true,'rating'=>4.9,'total_orders'=>310],

            // DRINKS
            ['category_id'=>$getCat('drinks-beverages'),'name'=>'Mango Lassi','slug'=>'mango-lassi','description'=>'Chilled blended yogurt with fresh Chaunsa mangoes and a hint of cardamom.','price'=>180,'image'=>'https://images.unsplash.com/photo-1544145945-f90425340c7e?w=600','cuisine'=>'Beverages','spicy_level'=>'mild','calories'=>220,'prep_time'=>5,'is_vegetarian'=>true,'is_halal'=>true,'is_popular'=>true,'rating'=>4.8,'total_orders'=>480],
            ['category_id'=>$getCat('drinks-beverages'),'name'=>'Fresh Mint Lemonade','slug'=>'fresh-mint-lemonade','description'=>'Freshly squeezed lemon with crushed mint and sugar. Refreshingly cold.','price'=>120,'image'=>'https://images.unsplash.com/photo-1523677011781-c91d1bbe2f9e?w=600','cuisine'=>'Beverages','spicy_level'=>'mild','calories'=>80,'prep_time'=>3,'is_vegetarian'=>true,'is_halal'=>true,'is_popular'=>true,'rating'=>4.7,'total_orders'=>520],
            ['category_id'=>$getCat('drinks-beverages'),'name'=>'Rooh Afza Sharbat','slug'=>'rooh-afza-sharbat','description'=>'Traditional Pakistani rose drink with basil seeds, milk, and rose syrup.','price'=>100,'image'=>'https://images.unsplash.com/photo-1551538827-9c037cb4f32a?w=600','cuisine'=>'Beverages','spicy_level'=>'mild','calories'=>120,'prep_time'=>2,'is_vegetarian'=>true,'is_halal'=>true,'rating'=>4.6,'total_orders'=>340],
            ['category_id'=>$getCat('drinks-beverages'),'name'=>'Chocolate Milkshake','slug'=>'chocolate-milkshake','description'=>'Thick and creamy chocolate milkshake blended with premium ice cream.','price'=>220,'discount_price'=>180,'image'=>'https://images.unsplash.com/photo-1572490122747-3968b75cc699?w=600','cuisine'=>'Beverages','spicy_level'=>'mild','calories'=>380,'prep_time'=>5,'is_vegetarian'=>true,'is_halal'=>true,'rating'=>4.7,'total_orders'=>290],

            // SEAFOOD
            ['category_id'=>$getCat('seafood'),'name'=>'Grilled Salmon','slug'=>'grilled-salmon','description'=>'Atlantic salmon fillet grilled with lemon herb butter sauce and seasonal vegetables.','price'=>980,'image'=>'https://images.unsplash.com/photo-1519708227418-c8fd9a32b7a2?w=600','cuisine'=>'Seafood','spicy_level'=>'mild','calories'=>420,'prep_time'=>25,'is_halal'=>true,'is_featured'=>true,'rating'=>4.8,'total_orders'=>165],
            ['category_id'=>$getCat('seafood'),'name'=>'Prawn Karahi','slug'=>'prawn-karahi','description'=>'Juicy prawns cooked in spicy tomato and ginger sauce. Pakistani style seafood.','price'=>780,'discount_price'=>680,'image'=>'https://images.unsplash.com/photo-1559847844-5315695dadae?w=600','cuisine'=>'Seafood','spicy_level'=>'hot','calories'=>380,'prep_time'=>20,'is_halal'=>true,'is_popular'=>true,'rating'=>4.7,'total_orders'=>245],
            ['category_id'=>$getCat('seafood'),'name'=>'Fish & Chips','slug'=>'fish-and-chips','description'=>'Beer-battered fish fillet with thick-cut chips and mushy peas. British classic.','price'=>520,'image'=>'https://images.unsplash.com/photo-1546833999-b9f581a1996d?w=600','cuisine'=>'Seafood','spicy_level'=>'mild','calories'=>680,'prep_time'=>18,'is_halal'=>true,'rating'=>4.5,'total_orders'=>190],

            // BREAKFAST
            ['category_id'=>$getCat('breakfast'),'name'=>'Halwa Puri','slug'=>'halwa-puri','description'=>'Traditional Pakistani breakfast — fluffy fried puri with sweet sooji halwa and chanay.','price'=>280,'image'=>'https://images.unsplash.com/photo-1533089860892-a7c6f0a88666?w=600','cuisine'=>'Breakfast','spicy_level'=>'mild','calories'=>580,'prep_time'=>20,'is_vegetarian'=>true,'is_halal'=>true,'is_popular'=>true,'is_featured'=>true,'rating'=>4.9,'total_orders'=>680],
            ['category_id'=>$getCat('breakfast'),'name'=>'Paratha Roll','slug'=>'paratha-roll','description'=>'Crispy layered paratha filled with egg, chicken and fresh vegetables. Street food classic.','price'=>180,'image'=>'https://images.unsplash.com/photo-1574894709920-11b28e7367e3?w=600','cuisine'=>'Breakfast','spicy_level'=>'mild','calories'=>420,'prep_time'=>12,'is_halal'=>true,'is_popular'=>true,'rating'=>4.7,'total_orders'=>520],
            ['category_id'=>$getCat('breakfast'),'name'=>'English Breakfast','slug'=>'english-breakfast','description'=>'Full English with eggs, halal sausages, beans, mushrooms, toast, and grilled tomatoes.','price'=>380,'discount_price'=>320,'image'=>'https://images.unsplash.com/photo-1533089860892-a7c6f0a88666?w=600','cuisine'=>'Breakfast','spicy_level'=>'mild','calories'=>720,'prep_time'=>18,'is_halal'=>true,'rating'=>4.5,'total_orders'=>185],

            // MEXICAN
            ['category_id'=>$getCat('mexican-food'),'name'=>'Chicken Tacos (3pc)','slug'=>'chicken-tacos','description'=>'Soft corn tortillas with spiced chicken, guacamole, salsa, and sour cream.','price'=>380,'image'=>'https://images.unsplash.com/photo-1565299507177-b0ac66763828?w=600','cuisine'=>'Mexican','spicy_level'=>'medium','calories'=>480,'prep_time'=>15,'is_halal'=>true,'is_popular'=>true,'rating'=>4.6,'total_orders'=>310],
            ['category_id'=>$getCat('mexican-food'),'name'=>'Beef Burrito','slug'=>'beef-burrito','description'=>'Large flour tortilla filled with seasoned beef, rice, beans, cheese, and fresh salsa.','price'=>420,'discount_price'=>360,'image'=>'https://images.unsplash.com/photo-1626700051175-6818013e1d4f?w=600','cuisine'=>'Mexican','spicy_level'=>'medium','calories'=>680,'prep_time'=>18,'is_halal'=>true,'rating'=>4.5,'total_orders'=>225],
            ['category_id'=>$getCat('mexican-food'),'name'=>'Nachos Supreme','slug'=>'nachos-supreme','description'=>'Crispy tortilla chips loaded with jalapeños, cheese sauce, guacamole, and sour cream.','price'=>320,'image'=>'https://images.unsplash.com/photo-1582169505937-b9992bd01ed9?w=600','cuisine'=>'Mexican','spicy_level'=>'hot','calories'=>560,'prep_time'=>10,'is_vegetarian'=>true,'is_halal'=>true,'rating'=>4.6,'total_orders'=>275],

            // SOUPS & SALADS
            ['category_id'=>$getCat('soups-salads'),'name'=>'Chicken Corn Soup','slug'=>'chicken-corn-soup','description'=>'Rich chicken broth with sweet corn, egg drops, and aromatic spices. Winter warmer.','price'=>220,'image'=>'https://images.unsplash.com/photo-1547592166-23ac45744acd?w=600','cuisine'=>'Soups','spicy_level'=>'mild','calories'=>180,'prep_time'=>12,'is_halal'=>true,'is_popular'=>true,'rating'=>4.6,'total_orders'=>380],
            ['category_id'=>$getCat('soups-salads'),'name'=>'Caesar Salad','slug'=>'caesar-salad','description'=>'Crisp romaine lettuce with Caesar dressing, parmesan shavings, and croutons.','price'=>280,'image'=>'https://images.unsplash.com/photo-1546793665-c74683f339c1?w=600','cuisine'=>'Salads','spicy_level'=>'mild','calories'=>280,'prep_time'=>8,'is_vegetarian'=>true,'is_halal'=>true,'rating'=>4.4,'total_orders'=>195],
            ['category_id'=>$getCat('soups-salads'),'name'=>'Mushroom Soup','slug'=>'mushroom-soup','description'=>'Creamy wild mushroom soup with truffle oil and fresh herbs. Velvety smooth.','price'=>240,'discount_price'=>200,'image'=>'https://images.unsplash.com/photo-1547592166-23ac45744acd?w=600','cuisine'=>'Soups','spicy_level'=>'mild','calories'=>220,'prep_time'=>15,'is_vegetarian'=>true,'is_halal'=>true,'rating'=>4.5,'total_orders'=>155],
        ];

        foreach($foods as $f) {
            Food::create(array_merge($f,[
                'is_available' => true,
                'is_vegetarian' => $f['is_vegetarian'] ?? false,
                'is_vegan' => false,
                'is_halal' => $f['is_halal'] ?? true,
                'is_featured' => $f['is_featured'] ?? false,
                'is_popular' => $f['is_popular'] ?? false,
                'rating_count' => rand(50,500),
                'total_orders' => $f['total_orders'] ?? rand(50,200),
            ]));
        }

        $this->command->info('✅ Seeded: 2 users, 12 categories, '.count($foods).' foods');
    }
}