<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ActivityCategoryController extends Controller
{
    public function index()
    {
        $categories = ActivityCategory::latest()->get();
        return view('admin.activity_categories.index', compact('categories'));
    }

    public function create()
    {
        $parentLocations = ActivityCategory::all();
        return view('admin.activity_categories.create', compact('parentLocations'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        ActivityCategory::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return redirect()->route('admin.activity-categories.index')->with('toast', 'Category created successfully!');
    }

    public function edit(ActivityCategory $activityCategory)
    {
        return view('admin.activity_categories.edit', compact('activityCategory'));
    }

    public function update(Request $request, ActivityCategory $activityCategory)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $activityCategory->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return redirect()->route('admin.activity-categories.index')->with('toast', 'Category updated successfully!');
    }

    public function destroy(ActivityCategory $activityCategory)
    {
        $activityCategory->delete();
        return redirect()->route('admin.activity-categories.index')->with('toast', 'Category deleted successfully!');
    }
}
