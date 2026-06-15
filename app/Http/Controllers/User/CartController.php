<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Food;
use App\Models\SpecialOffer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cart        = Cart::with('food.category')->where('user_id',Auth::id())->get();
        $subtotal    = $cart->sum('item_total');
        $deliveryFee = $subtotal >= 1000 ? 0 : 99;
        $tax         = round($subtotal * 0.05, 2);
        $discount    = session('coupon_discount', 0);
        $total       = $subtotal + $deliveryFee + $tax - $discount;

        return view('user.cart.index', compact('cart','subtotal','deliveryFee','tax','discount','total'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'food_id'  => 'required|exists:foods,id',
            'quantity' => 'nullable|integer|min:1|max:20',
        ]);

        $food = Food::findOrFail($request->food_id);

        if (!$food->is_available) {
            return response()->json(['success'=>false,'message'=>'This item is currently not available.']);
        }

        $existing = Cart::where('user_id',Auth::id())
            ->where('food_id',$request->food_id)->first();

        if ($existing) {
            $existing->update(['quantity' => $existing->quantity + ($request->quantity ?? 1)]);
        } else {
            Cart::create([
                'user_id'              => Auth::id(),
                'food_id'              => $request->food_id,
                'quantity'             => $request->quantity ?? 1,
                'add_ons'              => $request->add_ons,
                'size'                 => $request->size,
                'special_instructions' => $request->special_instructions,
            ]);
        }

        $count = Cart::where('user_id',Auth::id())->sum('quantity');
        return response()->json(['success'=>true,'message'=>'Added to cart! 🛒','count'=>$count,'cart_count'=>$count]);
    }

    public function update(Request $request, int $id)
    {
        $cart = Cart::where('user_id',Auth::id())->findOrFail($id);
        $cart->update(['quantity' => max(1, (int)$request->quantity)]);

        $allCart  = Cart::with('food')->where('user_id',Auth::id())->get();
        $subtotal = $allCart->sum('item_total');

        return response()->json([
            'success'    => true,
            'item_total' => $cart->item_total,
            'subtotal'   => $subtotal,
        ]);
    }

    public function remove(int $id)
    {
        Cart::where('user_id',Auth::id())->findOrFail($id)->delete();
        $count = Cart::where('user_id',Auth::id())->sum('quantity');
        return response()->json(['success'=>true,'message'=>'Item removed','count'=>$count]);
    }

    public function count()
    {
        $count = Auth::check() ? Cart::where('user_id',Auth::id())->sum('quantity') : 0;
        return response()->json(['count'=>$count]);
    }

    public function applyCoupon(Request $request)
    {
        $request->validate(['coupon'=>'required|string|max:30']);

        $offer = SpecialOffer::where('coupon_code', strtoupper($request->coupon))->first();
        $cart  = Cart::with('food')->where('user_id',Auth::id())->get();

        if ($cart->isEmpty()) {
            return response()->json(['success'=>false,'message'=>'Your cart is empty.']);
        }

        $subtotal = $cart->sum('item_total');

        if (!$offer || !$offer->isValid($subtotal, Auth::user())) {
            return response()->json(['success'=>false,'message'=>'Invalid or expired coupon code.']);
        }

        $discount = $offer->calculateDiscount($subtotal);
        $offer->increment('used_count');

        session(['applied_coupon'=>strtoupper($request->coupon),'coupon_discount'=>$discount]);

        return response()->json([
            'success'  => true,
            'discount' => $discount,
            'message'  => "🎉 Coupon applied! You saved Rs.".number_format($discount),
        ]);
    }

    public function removeCoupon()
    {
        session()->forget(['applied_coupon','coupon_discount']);
        return response()->json(['success'=>true,'message'=>'Coupon removed.']);
    }
}