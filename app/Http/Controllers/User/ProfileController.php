<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        $user  = Auth::user();
        $stats = [
            'total_orders'  => $user->orders()->count(),
            'total_spent'   => $user->orders()->where('status','delivered')->sum('total'),
            'loyalty_points'=> $user->loyalty_points,
            'loyalty_tier'  => $user->loyalty_tier,
        ];
        return view('user.profile.index', compact('user','stats'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $data = $request->validate([
            'name'    => 'required|string|max:100',
            'email'   => 'required|email|unique:users,email,'.$user->id,
            'phone'   => 'required|string|max:15|unique:users,phone,'.$user->id,
            'address' => 'nullable|string|max:500',
            'city'    => 'nullable|string|max:100',
            'avatar'  => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('avatar')) {
            if ($user->avatar && !str_starts_with($user->avatar,'http'))
                Storage::delete('public/'.$user->avatar);
            $data['avatar'] = $request->file('avatar')->store('avatars','public');
        }

        $user->update($data);
        return back()->with('success','Profile updated successfully! ✅');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password'         => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password'=>'Current password is incorrect.']);
        }

        $user->update(['password'=>Hash::make($request->password)]);
        return back()->with('success','Password changed successfully! 🔒');
    }

    public function notifications()
    {
        $notifications = Notification::where('user_id',Auth::id())
            ->orderByDesc('created_at')->paginate(15);

        Notification::where('user_id',Auth::id())
            ->where('is_read',false)->update(['is_read'=>true]);

        return view('user.profile.notifications', compact('notifications'));
    }

    public function notificationCount()
    {
        $count = Notification::where('user_id',Auth::id())
            ->where('is_read',false)->count();
        return response()->json(['count'=>$count]);
    }

    public function wishlist()
    {
        $wishlists = Auth::user()->wishlists()->with('food.category')->paginate(12);
        return view('user.profile.wishlist', compact('wishlists'));
    }

    public function toggleWishlist(Request $request)
    {
        $request->validate(['food_id'=>'required|exists:foods,id']);
        $user = Auth::user();

        $existing = $user->wishlists()->where('food_id',$request->food_id)->first();

        if ($existing) {
            $existing->delete();
            return response()->json(['success'=>true,'message'=>'Removed from wishlist','wishlisted'=>false]);
        }

        $user->wishlists()->create(['food_id'=>$request->food_id]);
        return response()->json(['success'=>true,'message'=>'Added to wishlist ❤️','wishlisted'=>true]);
    }
}