<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TourCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TourCategoryController extends Controller
{
    public function index()
    {
        $categories = TourCategory::latest()->get();
        return view('admin.tour-categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.tour-categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:tour_categories,name',
        ]);

        TourCategory::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return redirect()->route('admin.tour-categories.index')->with('success', 'Category created successfully.');
    }

    public function edit(TourCategory $tourCategory)
    {
        return view('admin.tour-categories.edit', compact('tourCategory'));
    }

    public function update(Request $request, TourCategory $tourCategory)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:tour_categories,name,' . $tourCategory->id,
        ]);

        $tourCategory->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return redirect()->route('admin.tour-categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(TourCategory $tourCategory)
    {
        $tourCategory->delete();
        return redirect()->route('admin.tour-categories.index')->with('success', 'Category deleted successfully.');
    }
}
