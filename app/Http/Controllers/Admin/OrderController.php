<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderTracking;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('user');

        if ($request->filled('status'))
            $query->where('status',$request->status);
        if ($request->filled('search')) {
            $query->where('order_number','like','%'.$request->search.'%')
                  ->orWhereHas('user', fn($q) => $q->where('name','like','%'.$request->search.'%')
                      ->orWhere('phone','like','%'.$request->search.'%'));
        }
        if ($request->filled('date'))
            $query->whereDate('created_at',$request->date);

        $orders = $query->orderByDesc('created_at')->paginate(20)->withQueryString();

        return view('admin.orders.index', compact('orders'));
    }

    public function show(int $id)
    {
        $order           = Order::with(['user','tracking','deliveryPerson'])->findOrFail($id);
        $deliveryPersons = User::where('role','delivery')->where('is_active',true)->get();
        return view('admin.orders.show', compact('order','deliveryPersons'));
    }

    public function updateStatus(Request $request, int $id)
    {
        $request->validate([
            'status' => 'required|in:confirmed,preparing,ready,picked_up,on_the_way,delivered,cancelled'
        ]);

        $order = Order::with('user')->findOrFail($id);
        $order->update(['status' => $request->status]);

        if ($request->status === 'delivered') {
            $order->update(['delivered_at' => now(), 'payment_status' => 'paid']);
        }

        $messages = [
            'confirmed'  => '✅ Your order has been confirmed!',
            'preparing'  => '👨‍🍳 Chef is preparing your order',
            'ready'      => '📦 Your order is ready!',
            'picked_up'  => '🛵 Rider has picked up your order',
            'on_the_way' => '🚴 Rider is on the way!',
            'delivered'  => '🎉 Order delivered! Enjoy your meal!',
            'cancelled'  => '❌ Your order has been cancelled.',
        ];

        OrderTracking::create([
            'order_id'   => $id,
            'status'     => $request->status,
            'message'    => $messages[$request->status] ?? 'Status updated',
            'tracked_at' => now(),
        ]);

        Notification::create([
            'user_id' => $order->user_id,
            'title'   => 'Order #'.$order->order_number.' Update',
            'message' => $messages[$request->status] ?? 'Your order status has been updated.',
            'type'    => 'order_update',
            'data'    => ['order_id'=>$order->id,'status'=>$request->status],
        ]);

        if ($request->expectsJson()) {
            return response()->json(['success'=>true,'message'=>'Status updated!']);
        }
        return back()->with('success','Order status updated to '.ucfirst(str_replace('_',' ',$request->status)));
    }

    public function assignDelivery(Request $request, int $id)
    {
        $request->validate(['delivery_person_id'=>'required|exists:users,id']);
        Order::findOrFail($id)->update(['delivery_person_id'=>$request->delivery_person_id]);
        return back()->with('success','Delivery person assigned!');
    }
}