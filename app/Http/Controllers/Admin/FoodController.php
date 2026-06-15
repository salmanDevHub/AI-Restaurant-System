<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Food;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class FoodController extends Controller
{
    public function index(Request $request)
    {
        $query = Food::with('category');

        if ($request->filled('search'))
            $query->where('name','like','%'.$request->search.'%');
        if ($request->filled('category'))
            $query->where('category_id',$request->category);
        if ($request->status === 'available')
            $query->where('is_available',true);
        elseif ($request->status === 'unavailable')
            $query->where('is_available',false);

        $foods      = $query->orderByDesc('created_at')->paginate(15)->withQueryString();
        $categories = Category::all();

        return view('admin.foods.index', compact('foods','categories'));
    }

    public function create()
    {
        $categories = Category::where('is_active',true)->get();
        return view('admin.foods.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'           => 'required|string|max:200',
            'category_id'    => 'required|exists:categories,id',
            'description'    => 'required|string',
            'price'          => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'cuisine'        => 'required|string',
            'spicy_level'    => 'required|in:mild,medium,hot,extra_hot',
            'calories'       => 'nullable|integer',
            'prep_time'      => 'nullable|integer',
            'image'          => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
        ]);

        $data['slug']          = Str::slug($request->name).'-'.uniqid();
        $data['is_available']  = $request->boolean('is_available', true);
        $data['is_featured']   = $request->boolean('is_featured');
        $data['is_popular']    = $request->boolean('is_popular');
        $data['is_vegetarian'] = $request->boolean('is_vegetarian');
        $data['is_halal']      = $request->boolean('is_halal', true);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('foods','public');
        }

        Food::create($data);

        return redirect()->route('admin.foods.index')
            ->with('success','✅ Food item created successfully!');
    }

    public function edit(int $id)
    {
        $food       = Food::findOrFail($id);
        $categories = Category::where('is_active',true)->get();
        return view('admin.foods.edit', compact('food','categories'));
    }

    public function update(Request $request, int $id)
    {
        $food = Food::findOrFail($id);

        $data = $request->validate([
            'name'           => 'required|string|max:200',
            'category_id'    => 'required|exists:categories,id',
            'description'    => 'required|string',
            'price'          => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'cuisine'        => 'required|string',
            'spicy_level'    => 'required|in:mild,medium,hot,extra_hot',
            'calories'       => 'nullable|integer',
            'prep_time'      => 'nullable|integer',
            'image'          => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
        ]);

        $data['is_available']  = $request->boolean('is_available');
        $data['is_featured']   = $request->boolean('is_featured');
        $data['is_popular']    = $request->boolean('is_popular');
        $data['is_vegetarian'] = $request->boolean('is_vegetarian');
        $data['is_halal']      = $request->boolean('is_halal');

        if ($request->hasFile('image')) {
            if ($food->image && !str_starts_with($food->image,'http'))
                Storage::delete('public/'.$food->image);
            $data['image'] = $request->file('image')->store('foods','public');
        }

        $food->update($data);

        return redirect()->route('admin.foods.index')
            ->with('success','✅ Food item updated!');
    }

    public function destroy(int $id)
    {
        Food::findOrFail($id)->delete();
        return back()->with('success','Food item deleted.');
    }

    public function toggleAvailable(int $id)
    {
        $food = Food::findOrFail($id);
        $food->update(['is_available' => !$food->is_available]);
        return response()->json(['success'=>true,'is_available'=>$food->is_available]);
    }
}