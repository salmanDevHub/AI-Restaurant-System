<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('foods')->orderBy('sort_order')->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'         => 'required|string|max:100',
            'description'  => 'nullable|string',
            'icon'         => 'nullable|string|max:10',
            'cuisine_type' => 'nullable|string|max:100',
            'sort_order'   => 'nullable|integer',
            'image'        => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data['slug']      = Str::slug($request->name).'-'.uniqid();
        $data['is_active'] = $request->boolean('is_active', true);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('categories','public');
        }

        Category::create($data);
        return redirect()->route('admin.categories.index')
            ->with('success','✅ Category created!');
    }

    public function edit(int $id)
    {
        $category = Category::findOrFail($id);
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, int $id)
    {
        $category = Category::findOrFail($id);

        $data = $request->validate([
            'name'         => 'required|string|max:100',
            'description'  => 'nullable|string',
            'icon'         => 'nullable|string|max:10',
            'cuisine_type' => 'nullable|string|max:100',
            'sort_order'   => 'nullable|integer',
            'image'        => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            if ($category->image && !str_starts_with($category->image,'http'))
                Storage::delete('public/'.$category->image);
            $data['image'] = $request->file('image')->store('categories','public');
        }

        $category->update($data);
        return redirect()->route('admin.categories.index')
            ->with('success','✅ Category updated!');
    }

    public function destroy(int $id)
    {
        Category::findOrFail($id)->delete();
        return back()->with('success','Category deleted.');
    }
}