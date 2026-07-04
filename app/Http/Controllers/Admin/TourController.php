<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tour;
use App\Models\TourCategory;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TourController extends Controller
{
    public function index()
    {
        $tours = Tour::with(['category', 'location', 'media'])->paginate(10);
        return view('admin.tours.index', compact('tours'));
    }

    public function create()
    {
        $categories = TourCategory::all();
        $locations = Location::all();
        $types = ['day_trip' => 'Day Trip', 'multi_day' => 'Multi-Day Tour'];
        return view('admin.tours.create', compact('categories', 'locations', 'types'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:day_trip,multi_day',
            'title' => 'required|string|max:255',
            'overview' => 'required',
            'duration' => 'required|string|max:255',
            'group_size' => 'required|integer',
            'age_range' => 'required|string|max:50',
            'base_price' => 'required|numeric',
            'category_id' => 'required|exists:tour_categories,id',
            'location_id' => 'required|exists:locations,id',
            'bestseller_flag' => 'boolean',
            'free_cancellation_flag' => 'boolean',
            'highlights' => 'nullable|string',
            'map_frame' => 'nullable|string',
            'languages' => 'nullable|string',
            'included' => 'nullable|string',
            'excluded' => 'nullable|string',
            'itinerary' => 'nullable|string',
            'gallery.*' => 'nullable|image|max:2048',
            'image' => 'nullable|image|max:2048',
            'gallery_alt.*' => 'nullable|string|max:255',
            'gallery_title.*' => 'nullable|string|max:255',
            'gallery_caption.*' => 'nullable|string|max:255',
            'gallery_description.*' => 'nullable|string',
            'cover_alt' => 'nullable|string|max:255',
            'cover_title' => 'nullable|string|max:255',
            'cover_caption' => 'nullable|string|max:255',
            'cover_description' => 'nullable|string',
        ]);

        $validated['slug'] = $this->generateUniqueSlug($validated['title']);
        $validated['bestseller_flag'] = $request->has('bestseller_flag');
        $validated['free_cancellation_flag'] = $request->has('free_cancellation_flag');
        $validated['type'] = $request->input('type', 'multi_day');

        $validated['highlights'] = !empty($validated['highlights'])
            ? array_map('trim', explode(',', $validated['highlights']))
            : [];

        $validated['languages'] = !empty($validated['languages'])
            ? array_map('trim', explode(',', $validated['languages']))
            : [];

        foreach (['included', 'excluded'] as $field) {
            $validated[$field] = !empty($validated[$field])
                ? array_map('trim', explode(',', $validated[$field]))
                : [];
        }

        $validated['itinerary'] = !empty($validated['itinerary'])
            ? array_filter(
                array_map(
                    'trim',
                    preg_split('/\r\n|\r|\n/', $validated['itinerary'])
                )
            )
            : [];

        $validated['highlights'] = json_encode($validated['highlights']);
        $validated['languages'] = json_encode($validated['languages']);
        $validated['included'] = json_encode($validated['included']);
        $validated['excluded'] = json_encode($validated['excluded']);
        $validated['itinerary'] = json_encode($validated['itinerary']);

        $tour = Tour::create($validated);

        // ✅ Save cover image
        if ($request->hasFile('image')) {
            $media = $tour->addMediaFromRequest('image')->toMediaCollection('cover');
            $media->setCustomProperty('alt', $request->cover_alt ?? '');
            $media->setCustomProperty('title', $request->cover_title ?? '');
            $media->setCustomProperty('caption', $request->cover_caption ?? '');
            $media->setCustomProperty('description', $request->cover_description ?? '');
            $media->save();
        }

        // ✅ Save gallery images
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $index => $image) {
                $media = $tour->addMedia($image)->toMediaCollection('gallery');
                $media->setCustomProperty('alt', $request->gallery_alt[$index] ?? '');
                $media->setCustomProperty('title', $request->gallery_title[$index] ?? '');
                $media->setCustomProperty('caption', $request->gallery_caption[$index] ?? '');
                $media->setCustomProperty('description', $request->gallery_description[$index] ?? '');
                $media->save();
            }
        }

        return redirect()->route('admin.tours.index')
            ->with('success', 'Tour created successfully.');
    }

    public function edit(Tour $tour)
    {
        $categories = TourCategory::all();
        $locations = Location::all();
        $types = ['day_trip' => 'Day Trip', 'multi_day' => 'Multi-Day Tour'];
        return view('admin.tours.edit', compact('tour', 'categories', 'locations', 'types'));
    }

    public function update(Request $request, Tour $tour)
    {
        $validated = $request->validate([
            'type' => 'required|in:day_trip,multi_day',
            'title' => 'required|string|max:255',
            'overview' => 'required',
            'duration' => 'required|string|max:255',
            'group_size' => 'required|integer',
            'age_range' => 'required|string|max:50',
            'base_price' => 'required|numeric',
            'category_id' => 'required|exists:tour_categories,id',
            'location_id' => 'required|exists:locations,id',
            'bestseller_flag' => 'boolean',
            'free_cancellation_flag' => 'boolean',
            'highlights' => 'nullable|string',
            'map_frame' => 'nullable|string',
            'languages' => 'nullable|string',
            'included' => 'nullable|string',
            'excluded' => 'nullable|string',
            'itinerary' => 'nullable|string',
            'gallery.*' => 'nullable|image|max:2048',
            'image' => 'nullable|image|max:2048',
            'delete_gallery' => 'nullable|array',
            'delete_gallery.*' => 'nullable|integer',
            'gallery_alt.*' => 'nullable|string|max:255',
            'gallery_title.*' => 'nullable|string|max:255',
            'gallery_caption.*' => 'nullable|string|max:255',
            'gallery_description.*' => 'nullable|string',
            'cover_alt' => 'nullable|string|max:255',
            'cover_title' => 'nullable|string|max:255',
            'cover_caption' => 'nullable|string|max:255',
            'cover_description' => 'nullable|string',
        ]);

        $validated['type'] = $request->input('type', 'multi_day');

        if ($tour->title !== $validated['title']) {
            $validated['slug'] = $this->generateUniqueSlug($validated['title']);
        } else {
            $validated['slug'] = $tour->slug;
        }

        $validated['bestseller_flag'] = $request->has('bestseller_flag');
        $validated['free_cancellation_flag'] = $request->has('free_cancellation_flag');

        $validated['highlights'] = !empty($validated['highlights'])
            ? array_map('trim', explode(',', $validated['highlights']))
            : [];

        $validated['languages'] = !empty($validated['languages'])
            ? array_map('trim', explode(',', $validated['languages']))
            : [];

        foreach (['included', 'excluded'] as $field) {
            $validated[$field] = !empty($validated[$field])
                ? array_map('trim', explode(',', $validated[$field]))
                : [];
        }

        $validated['itinerary'] = !empty($validated['itinerary'])
            ? array_filter(
                array_map(
                    'trim',
                    preg_split('/\r\n|\r|\n/', $validated['itinerary'])
                )
            )
            : [];

        $validated['highlights'] = json_encode($validated['highlights']);
        $validated['languages'] = json_encode($validated['languages']);
        $validated['included'] = json_encode($validated['included']);
        $validated['excluded'] = json_encode($validated['excluded']);
        $validated['itinerary'] = json_encode($validated['itinerary']);

        $tour->update($validated);

        $cover = $tour->getFirstMedia('cover');
        if ($cover && !$request->hasFile('image')) {
            $cover->setCustomProperty('alt', $request->input('existing_cover_alt', ''));
            $cover->setCustomProperty('title', $request->input('existing_cover_title', ''));
            $cover->setCustomProperty('caption', $request->input('existing_cover_caption', ''));
            $cover->setCustomProperty('description', $request->input('existing_cover_description', ''));
            $cover->save();
        }

        if ($request->filled('existing_gallery_alt')) {
            foreach ($request->input('existing_gallery_alt') as $mediaId => $alt) {
                $media = $tour->media()->find($mediaId);
                if ($media) {
                    $media->setCustomProperty('alt', $alt);
                    $media->setCustomProperty('title', $request->input('existing_gallery_title.' . $mediaId, ''));
                    $media->setCustomProperty('caption', $request->input('existing_gallery_caption.' . $mediaId, ''));
                    $media->setCustomProperty('description', $request->input('existing_gallery_description.' . $mediaId, ''));
                    $media->save();
                }
            }
        }

        // ✅ Update cover image
        if ($request->hasFile('image')) {
            $tour->clearMediaCollection('cover');

            $media = $tour->addMediaFromRequest('image')->toMediaCollection('cover');
            $media->setCustomProperty('alt', $request->cover_alt ?? '');
            $media->setCustomProperty('title', $request->cover_title ?? '');
            $media->setCustomProperty('caption', $request->cover_caption ?? '');
            $media->setCustomProperty('description', $request->cover_description ?? '');
            $media->save();
        }

        // ✅ Delete selected gallery images
        if ($request->filled('delete_gallery')) {
            foreach ($request->input('delete_gallery') as $mediaId) {
                $mediaItem = $tour->media()->find($mediaId);
                if ($mediaItem) {
                    $mediaItem->delete();
                }
            }
        }

        // ✅ Add new gallery images
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $index => $image) {
                $media = $tour->addMedia($image)->toMediaCollection('gallery');
                $media->setCustomProperty('alt', $request->gallery_alt[$index] ?? '');
                $media->setCustomProperty('title', $request->gallery_title[$index] ?? '');
                $media->setCustomProperty('caption', $request->gallery_caption[$index] ?? '');
                $media->setCustomProperty('description', $request->gallery_description[$index] ?? '');
                $media->save();
            }
        }

        return redirect()->route('admin.tours.index')
            ->with('success', 'Tour updated successfully.');
    }

    public function destroy(Tour $tour)
    {
        $tour->delete();
        return redirect()->route('admin.tours.index')
            ->with('success', 'Tour deleted.');
    }

    private function generateUniqueSlug($title)
    {
        $slug = Str::slug($title);
        $original = $slug;
        $counter = 1;

        while (Tour::where('slug', $slug)->exists()) {
            $slug = $original . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
}
