<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role','user');

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(fn($q) =>
                $q->where('name','like',"%$s%")
                  ->orWhere('email','like',"%$s%")
                  ->orWhere('phone','like',"%$s%")
            );
        }
        if ($request->filled('tier'))
            $query->where('loyalty_tier',$request->tier);

        $users = $query->orderByDesc('created_at')->paginate(20)->withQueryString();
        return view('admin.users.index', compact('users'));
    }

    public function show(int $id)
    {
        $user = User::with([
            'orders' => fn($q) => $q->orderByDesc('created_at')->limit(10)
        ])->findOrFail($id);
        return view('admin.users.show', compact('user'));
    }

    public function toggleBlock(int $id)
    {
        $user = User::findOrFail($id);
        $user->update(['is_blocked' => !$user->is_blocked]);
        $msg = $user->is_blocked ? 'User has been blocked.' : 'User has been unblocked.';
        return back()->with('success', $msg);
    }
}