<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderTracking;
use App\Models\Food;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function checkout()
    {
        $cart = Cart::with('food')->where('user_id',Auth::id())->get();
        if ($cart->isEmpty()) return redirect()->route('user.cart')->with('error','Your cart is empty!');

        $subtotal    = $cart->sum('item_total');
        $discount    = session('coupon_discount', 0);
        $deliveryFee = $subtotal >= 1000 ? 0 : 99;
        $tax         = round(($subtotal - $discount) * 0.05, 2);
        $total       = $subtotal - $discount + $deliveryFee + $tax;

        return view('user.orders.checkout', compact('cart','subtotal','discount','deliveryFee','tax','total'));
    }

    public function placeOrder(Request $request)
    {
        $request->validate([
            'delivery_name'    => 'required|string|max:100',
            'delivery_phone'   => 'required|string|max:20',
            'delivery_address' => 'required|string|max:500',
            'delivery_city'    => 'required|string|max:100',
            'type'             => 'required|in:delivery,pickup,dine_in',
            'payment_method'   => 'required|in:cash,card,online,wallet',
        ]);

        $cart = Cart::with('food')->where('user_id',Auth::id())->get();
        if ($cart->isEmpty()) return back()->with('error','Your cart is empty!');

        $orderId = null;

        DB::transaction(function () use ($request, $cart, &$orderId) {
            $subtotal    = $cart->sum('item_total');
            $discount    = session('coupon_discount', 0);
            $deliveryFee = $subtotal >= 1000 ? 0 : 99;
            $tax         = round(($subtotal - $discount) * 0.05, 2);
            $total       = $subtotal - $discount + $deliveryFee + $tax;

            $items = $cart->map(fn($c) => [
                'food_id'  => $c->food_id,
                'name'     => $c->food->name,
                'price'    => $c->food->effective_price,
                'quantity' => $c->quantity,
                'add_ons'  => $c->add_ons,
                'size'     => $c->size,
            ])->toArray();

            $pointsEarned = (int)($total / 100);

            $order = Order::create([
                'order_number'         => Order::generateOrderNumber(),
                'user_id'              => Auth::id(),
                'items'                => $items,
                'subtotal'             => $subtotal,
                'delivery_fee'         => $deliveryFee,
                'tax'                  => $tax,
                'discount'             => $discount,
                'total'                => $total,
                'coupon_code'          => session('applied_coupon'),
                'type'                 => $request->type,
                'status'               => 'pending',
                'payment_method'       => $request->payment_method,
                'payment_status'       => 'pending',
                'delivery_name'        => $request->delivery_name,
                'delivery_phone'       => $request->delivery_phone,
                'delivery_address'     => $request->delivery_address,
                'delivery_city'        => $request->delivery_city,
                'delivery_postal_code' => $request->delivery_postal_code,
                'special_instructions' => $request->special_instructions,
                'estimated_delivery_at'=> now()->addMinutes(45),
                'loyalty_points_earned'=> $pointsEarned,
            ]);

            OrderTracking::create([
                'order_id'   => $order->id,
                'status'     => 'pending',
                'message'    => 'Order placed successfully! Waiting for confirmation.',
                'tracked_at' => now(),
            ]);

            $user = Auth::user();
            $user->increment('total_orders');
            $user->increment('total_spent', $total);
            $user->increment('loyalty_points', $pointsEarned);
            $user->updateLoyaltyTier();

            foreach ($cart as $item) {
                Food::where('id',$item->food_id)->increment('total_orders',$item->quantity);
            }

            Cart::where('user_id',Auth::id())->delete();
            session()->forget(['applied_coupon','coupon_discount']);

            Notification::create([
                'user_id' => Auth::id(),
                'title'   => '✅ Order Confirmed!',
                'message' => "Your order #{$order->order_number} of Rs.".number_format($total)." placed! +{$pointsEarned} loyalty points.",
                'type'    => 'order_update',
                'data'    => ['order_id'=>$order->id,'order_number'=>$order->order_number],
            ]);

            $orderId = $order->id;
        });

        return redirect()->route('user.orders.success')->with([
            'success'       => 'Order placed successfully! 🎉',
            'last_order_id' => $orderId,
        ]);
    }

    public function success()
    {
        $orderId = session('last_order_id');
        $order   = $orderId ? Order::with('tracking')->find($orderId) : null;
        return view('user.orders.success', compact('order'));
    }

    public function index()
    {
        $orders = Order::where('user_id',Auth::id())
            ->orderByDesc('created_at')->paginate(10);
        return view('user.orders.index', compact('orders'));
    }

    public function show(int $id)
    {
        $order = Order::with(['tracking','deliveryPerson'])
            ->where('user_id',Auth::id())->findOrFail($id);
        return view('user.orders.show', compact('order'));
    }

    public function track(int $id)
    {
        $order = Order::with('tracking')->where('user_id',Auth::id())->findOrFail($id);

        if (request()->expectsJson()) {
            return response()->json([
                'status'   => $order->status,
                'tracking' => $order->tracking,
                'badge'    => $order->status_badge,
            ]);
        }

        return view('user.orders.track', compact('order'));
    }
}