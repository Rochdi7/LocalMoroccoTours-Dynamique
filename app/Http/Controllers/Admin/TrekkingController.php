<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Trekking;
use App\Models\Location;
use App\Models\TrekkingCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TrekkingController extends Controller
{
    public function index()
    {
        $treks = Trekking::with(['category', 'location', 'media'])->paginate(10);
        return view('admin.trekking.index', compact('treks'));
    }

    public function create()
    {
        $categories = TrekkingCategory::all();
        $locations = Location::all();
        return view('admin.trekking.create', compact('categories', 'locations'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'overview' => 'required',
            'duration' => 'required|string|max:255',
            'group_size' => 'required|integer',
            'age_range' => 'required|string|max:50',
            'base_price' => 'required|numeric',
            'difficulty_level' => 'required|in:Easy,Moderate,Hard,Expert',
            'max_altitude' => 'nullable|integer',
            'category_id' => 'required|exists:trekking_categories,id',
            'location_id' => 'nullable|exists:locations,id',
            'bestseller_flag' => 'boolean',
            'free_cancellation_flag' => 'boolean',
            'highlights' => 'nullable|string',
            'languages' => 'nullable|string',
            'map_frame' => 'nullable|string',
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

        $trek = Trekking::create($validated);

        if ($request->hasFile('image')) {
            $media = $trek->addMediaFromRequest('image')->toMediaCollection('cover');

            $media->setCustomProperty('alt', $request->cover_alt ?? '');
            $media->setCustomProperty('title', $request->cover_title ?? '');
            $media->setCustomProperty('caption', $request->cover_caption ?? '');
            $media->setCustomProperty('description', $request->cover_description ?? '');
            $media->save();
        }

        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $index => $image) {
                $media = $trek->addMedia($image)->toMediaCollection('gallery');

                $media->setCustomProperty('alt', $request->gallery_alt[$index] ?? '');
                $media->setCustomProperty('title', $request->gallery_title[$index] ?? '');
                $media->setCustomProperty('caption', $request->gallery_caption[$index] ?? '');
                $media->setCustomProperty('description', $request->gallery_description[$index] ?? '');
                $media->save();
            }
        }

        return redirect()->route('admin.trekking.index')
            ->with('success', 'Trekking created successfully.');
    }

    public function edit(Trekking $trekking)
    {
        $categories = TrekkingCategory::all();
        $locations = Location::all();
        $tour = $trekking;
        return view('admin.trekking.edit', compact('trekking', 'categories', 'tour', 'locations'));
    }

    public function update(Request $request, Trekking $trekking)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'overview' => 'required',
            'duration' => 'required|string|max:255',
            'group_size' => 'required|integer',
            'age_range' => 'required|string|max:50',
            'base_price' => 'required|numeric',
            'difficulty_level' => 'required|in:Easy,Moderate,Hard,Expert',
            'max_altitude' => 'nullable|integer',
            'category_id' => 'required|exists:trekking_categories,id',
            'location_id' => 'nullable|exists:locations,id',
            'bestseller_flag' => 'boolean',
            'free_cancellation_flag' => 'boolean',
            'highlights' => 'nullable|string',
            'languages' => 'nullable|string',
            'map_frame' => 'nullable|string',
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

        if ($trekking->title !== $validated['title']) {
            $validated['slug'] = $this->generateUniqueSlug($validated['title']);
        } else {
            $validated['slug'] = $trekking->slug;
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

        $trekking->update($validated);

        if ($request->filled('existing_gallery_ids')) {
            foreach ($request->input('existing_gallery_ids') as $id) {
                $media = $trekking->media()->find($id);
                if ($media) {
                    $media->setCustomProperty('alt', $request->input("existing_gallery_alt.$id", ''));
                    $media->setCustomProperty('title', $request->input("existing_gallery_title.$id", ''));
                    $media->setCustomProperty('caption', $request->input("existing_gallery_caption.$id", ''));
                    $media->setCustomProperty('description', $request->input("existing_gallery_description.$id", ''));
                    $media->save();
                }
            }
        }

        if ($request->hasFile('image')) {
            $trekking->clearMediaCollection('cover');

            $media = $trekking->addMediaFromRequest('image')->toMediaCollection('cover');

            $media->setCustomProperty('alt', $request->cover_alt ?? '');
            $media->setCustomProperty('title', $request->cover_title ?? '');
            $media->setCustomProperty('caption', $request->cover_caption ?? '');
            $media->setCustomProperty('description', $request->cover_description ?? '');
            $media->save();
        }

        if ($request->filled('delete_gallery')) {
            foreach ($request->input('delete_gallery') as $mediaId) {
                $mediaItem = $trekking->media()->find($mediaId);
                if ($mediaItem) {
                    $mediaItem->delete();
                }
            }
        }

        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $index => $file) {
                $media = $trekking->addMedia($file)->toMediaCollection('gallery');

                $media->setCustomProperty('alt', $request->gallery_alt[$index] ?? '');
                $media->setCustomProperty('title', $request->gallery_title[$index] ?? '');
                $media->setCustomProperty('caption', $request->gallery_caption[$index] ?? '');
                $media->setCustomProperty('description', $request->gallery_description[$index] ?? '');
                $media->save();
            }
        }

        return redirect()->route('admin.trekking.index')
            ->with('success', 'Trekking updated successfully!');
    }

    public function destroy(Trekking $trekking)
    {
        $trekking->delete();
        return redirect()->route('admin.trekking.index')
            ->with('success', 'Trekking deleted.');
    }

    private function generateUniqueSlug($title)
    {
        $slug = Str::slug($title);
        $original = $slug;
        $counter = 1;

        while (Trekking::where('slug', $slug)->exists()) {
            $slug = $original . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
}
