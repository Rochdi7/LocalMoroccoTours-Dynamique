<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TrekkingCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TrekkingCategoryController extends Controller
{
    public function index()
    {
        $categories = TrekkingCategory::latest()->get();
        return view('admin.trekking_categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.trekking_categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        TrekkingCategory::create($validated);

        return redirect()->route('admin.trekking-categories.index')->with('toast', 'Category created successfully!');
    }

    public function edit(TrekkingCategory $trekkingCategory)
    {
        return view('admin.trekking_categories.edit', compact('trekkingCategory'));
    }

    public function update(Request $request, TrekkingCategory $trekkingCategory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        $trekkingCategory->update($validated);

        return redirect()->route('admin.trekking-categories.index')->with('toast', 'Category updated successfully!');
    }

    public function destroy(TrekkingCategory $trekkingCategory)
    {
        $trekkingCategory->delete();
        return redirect()->route('admin.trekking-categories.index')->with('toast', 'Category deleted successfully!');
    }
}
