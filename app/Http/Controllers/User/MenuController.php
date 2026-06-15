<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Food;
use App\Models\Category;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $query = Food::where('is_available',true)->with('category');

        if ($request->filled('category'))
            $query->whereHas('category', fn($q) => $q->where('slug',$request->category));
        if ($request->filled('cuisine'))
            $query->where('cuisine',$request->cuisine);
        if ($request->filled('search'))
            $query->where('name','like','%'.$request->search.'%');
        if ($request->filled('spicy'))
            $query->where('spicy_level',$request->spicy);
        if ($request->filled('veg'))
            $query->where('is_vegetarian',true);

        match ($request->sort) {
            'price_asc'  => $query->orderBy('price'),
            'price_desc' => $query->orderByDesc('price'),
            'rating'     => $query->orderByDesc('rating'),
            'popular'    => $query->orderByDesc('total_orders'),
            default      => $query->orderByDesc('is_featured')->orderByDesc('rating'),
        };

        $foods      = $query->paginate(12)->withQueryString();
        $categories = Category::where('is_active',true)->withCount('activeFoods')->orderBy('sort_order')->get();
        $cuisines   = Food::where('is_available',true)->distinct()->pluck('cuisine');

        return view('user.menu.index', compact('foods','categories','cuisines'));
    }

    public function show(string $slug)
    {
        $food    = Food::with(['category','reviews.user'])->where('slug',$slug)->firstOrFail();
        $related = Food::where('category_id',$food->category_id)
            ->where('id','!=',$food->id)
            ->where('is_available',true)
            ->limit(4)->get();

        return view('user.menu.show', compact('food','related'));
    }
}