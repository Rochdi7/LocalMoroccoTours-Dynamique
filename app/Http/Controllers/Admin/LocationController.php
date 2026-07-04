<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LocationController extends Controller
{
    public function index()
    {
        $locations = Location::orderBy('name')->paginate(10);

        return view('admin.locations.index', compact('locations'));
    }

    public function create()
    {
        return view('admin.locations.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:locations,slug',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'seo_alt' => 'nullable|string|max:255',
            'seo_caption' => 'nullable|string|max:255',
            'seo_description' => 'nullable|string',
        ]);

        $location = new Location();
        $location->name = $validated['name'];
        $location->slug = $validated['slug'] ?? Str::slug($validated['name']);
        $location->description = $validated['description'] ?? null;
        $location->save();

        if ($request->hasFile('image')) {
            $media = $location
                ->addMediaFromRequest('image')
                ->toMediaCollection('locations');

            $media->setCustomProperty('alt', $validated['seo_alt'] ?? '');
            $media->setCustomProperty('caption', $validated['seo_caption'] ?? '');
            $media->setCustomProperty('description', $validated['seo_description'] ?? '');
            $media->save();
        }

        return redirect()->route('admin.locations.index')
            ->with('toast', 'Location created successfully.');
    }

    public function edit(Location $location)
    {
        $media = $location->getFirstMedia('locations');

        return view('admin.locations.edit', compact('location', 'media'));
    }

    public function update(Request $request, Location $location)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:locations,slug,' . $location->id,
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'seo_alt' => 'nullable|string|max:255',
            'seo_caption' => 'nullable|string|max:255',
            'seo_description' => 'nullable|string',
        ]);

        $location->name = $validated['name'];
        $location->slug = $validated['slug'] ?? Str::slug($validated['name']);
        $location->description = $validated['description'] ?? null;
        $location->save();

        if ($request->hasFile('image')) {
            $location->clearMediaCollection('locations');

            $media = $location
                ->addMediaFromRequest('image')
                ->toMediaCollection('locations');

            $media->setCustomProperty('alt', $validated['seo_alt'] ?? '');
            $media->setCustomProperty('caption', $validated['seo_caption'] ?? '');
            $media->setCustomProperty('description', $validated['seo_description'] ?? '');
            $media->save();
        } elseif ($location->getFirstMedia('locations')) {
            // If no new file uploaded, update existing media metadata
            $media = $location->getFirstMedia('locations');
            $media->setCustomProperty('alt', $validated['seo_alt'] ?? '');
            $media->setCustomProperty('caption', $validated['seo_caption'] ?? '');
            $media->setCustomProperty('description', $validated['seo_description'] ?? '');
            $media->save();
        }

        return redirect()->route('admin.locations.index')
            ->with('toast', 'Location updated successfully.');
    }

    public function destroy(Location $location)
    {
        $location->clearMediaCollection('locations');
        $location->delete();

        return redirect()->route('admin.locations.index')
            ->with('toast', 'Location deleted successfully.');
    }

    public function show(Location $location)
    {
        return view('front.locations.show', compact('location'));
    }
}
