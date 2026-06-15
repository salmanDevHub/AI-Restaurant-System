<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Food;
use App\Models\Category;
use App\Models\SpecialOffer;

class HomeController extends Controller
{
    public function index()
    {
        try {
            $featuredFoods = Food::where('is_featured', true)
                ->where('is_available', true)
                ->with('category')
                ->limit(8)->get();

            $popularFoods = Food::where('is_popular', true)
                ->where('is_available', true)
                ->with('category')
                ->orderByDesc('total_orders')
                ->limit(12)->get();

            $categories = Category::where('is_active', true)
                ->orderBy('sort_order')->get();

            $offers = SpecialOffer::where('is_active', true)
                ->where('ends_at', '>', now())
                ->limit(3)->get();
        } catch (\Throwable $e) {
            \Log::warning('Unable to load home page data: ' . $e->getMessage());

            $featuredFoods = collect();
            $popularFoods = collect();
            $categories = collect();
            $offers = collect();
        }

        return view('user.home.index', compact(
            'featuredFoods', 'popularFoods', 'categories', 'offers'
        ));
    }
}