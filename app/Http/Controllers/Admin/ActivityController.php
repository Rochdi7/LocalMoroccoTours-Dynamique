<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\ActivityCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ActivityController extends Controller
{
    public function index()
    {
        $activities = Activity::with(['category', 'media'])->latest()->get();
        return view('admin.activities.index', compact('activities'));
    }

    public function create()
    {
        $categories = ActivityCategory::all();
        return view('admin.activities.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $this->validateData($request);

        $validated['slug'] = $this->generateUniqueSlug($validated['title']);

        $activity = Activity::create($validated);

        // ✅ Save cover image and metadata
        if ($request->hasFile('image')) {
            $media = $activity->addMediaFromRequest('image')
                ->toMediaCollection('cover');

            $media->setCustomProperty('alt', $request->input('cover_alt', ''));
            $media->setCustomProperty('title', $request->input('cover_title', ''));
            $media->setCustomProperty('caption', $request->input('cover_caption', ''));
            $media->setCustomProperty('description', $request->input('cover_description', ''));
            $media->save();
        }

        // ✅ Save gallery images + metadata
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $index => $image) {
                $media = $activity->addMedia($image)
                    ->toMediaCollection('gallery');

                $media->setCustomProperty('alt', $request->input('gallery_alt')[$index] ?? '');
                $media->setCustomProperty('title', $request->input('gallery_title')[$index] ?? '');
                $media->setCustomProperty('caption', $request->input('gallery_caption')[$index] ?? '');
                $media->setCustomProperty('description', $request->input('gallery_description')[$index] ?? '');
                $media->save();
            }
        }

        return redirect()->route('admin.activities.index')
            ->with('success', 'Activity created successfully.');
    }

    public function edit(Activity $activity)
    {
        $categories = ActivityCategory::all();
        return view('admin.activities.edit', compact('activity', 'categories'));
    }

    public function update(Request $request, Activity $activity)
    {
        $validated = $this->validateData($request);

        if ($activity->title !== $validated['title']) {
            $validated['slug'] = $this->generateUniqueSlug($validated['title']);
        } else {
            $validated['slug'] = $activity->slug;
        }

        $activity->update($validated);

        // ✅ Update cover image
        if ($request->hasFile('image')) {
            $activity->clearMediaCollection('cover');
            $media = $activity->addMediaFromRequest('image')
                ->toMediaCollection('cover');

            $media->setCustomProperty('alt', $request->input('cover_alt', ''));
            $media->setCustomProperty('title', $request->input('cover_title', ''));
            $media->setCustomProperty('caption', $request->input('cover_caption', ''));
            $media->setCustomProperty('description', $request->input('cover_description', ''));
            $media->save();
        } else {
            // ✅ Update cover metadata if no new file uploaded
            $media = $activity->getFirstMedia('cover');
            if ($media) {
                $media->setCustomProperty('alt', $request->input('cover_alt', ''));
                $media->setCustomProperty('title', $request->input('cover_title', ''));
                $media->setCustomProperty('caption', $request->input('cover_caption', ''));
                $media->setCustomProperty('description', $request->input('cover_description', ''));
                $media->save();
            }
        }

        // ✅ Delete selected gallery images
        if ($request->filled('delete_gallery')) {
            foreach ($request->input('delete_gallery') as $mediaId) {
                $mediaItem = $activity->media()->find($mediaId);
                if ($mediaItem) {
                    $mediaItem->delete();
                }
            }
        }

        // ✅ Add new gallery images with metadata
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $index => $image) {
                $media = $activity->addMedia($image)
                    ->toMediaCollection('gallery');

                $media->setCustomProperty('alt', $request->input('gallery_alt')[$index] ?? '');
                $media->setCustomProperty('title', $request->input('gallery_title')[$index] ?? '');
                $media->setCustomProperty('caption', $request->input('gallery_caption')[$index] ?? '');
                $media->setCustomProperty('description', $request->input('gallery_description')[$index] ?? '');
                $media->save();
            }
        }

        return redirect()->route('admin.activities.index')
            ->with('success', 'Activity updated successfully.');
    }

    public function destroy(Activity $activity)
    {
        $activity->delete();
        return redirect()->route('admin.activities.index')
            ->with('success', 'Activity deleted successfully.');
    }

    /**
     * Generate unique slug.
     */
    private function generateUniqueSlug($title)
    {
        $slug = Str::slug($title);
        $original = $slug;
        $counter = 1;

        while (Activity::where('slug', $slug)->exists()) {
            $slug = $original . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    /**
     * Shared validation + data transformation.
     */
    private function validateData(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'overview' => 'required',
            'duration' => 'required|string|max:255',
            'group_size' => 'required|integer',
            'age_range' => 'required|string|max:50',
            'base_price' => 'required|numeric',
            'category_id' => 'required|exists:activity_categories,id',
            'bestseller_flag' => 'boolean',
            'free_cancellation_flag' => 'boolean',
            'highlights' => 'nullable|string',
            'included' => 'nullable|string',
            'excluded' => 'nullable|string',
            'itinerary' => 'nullable|string',
            'map_frame' => 'nullable|string',
            'languages' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'gallery.*' => 'nullable|image|max:2048',
            'delete_gallery' => 'nullable|array',
            'delete_gallery.*' => 'nullable|integer',

            // ✅ Additional validations for metadata fields
            'cover_alt' => 'nullable|string|max:255',
            'cover_title' => 'nullable|string|max:255',
            'cover_caption' => 'nullable|string|max:255',
            'cover_description' => 'nullable|string',
            'gallery_alt.*' => 'nullable|string|max:255',
            'gallery_title.*' => 'nullable|string|max:255',
            'gallery_caption.*' => 'nullable|string|max:255',
            'gallery_description.*' => 'nullable|string',
        ]);

        $validated['bestseller_flag'] = $request->has('bestseller_flag');
        $validated['free_cancellation_flag'] = $request->has('free_cancellation_flag');

        $validated['highlights'] = !empty($validated['highlights'])
            ? array_map('trim', explode(',', $validated['highlights']))
            : [];

        foreach (['included', 'excluded'] as $field) {
            $validated[$field] = !empty($validated[$field])
                ? array_map('trim', explode(',', $validated[$field]))
                : [];
        }

        $validated['itinerary'] = !empty($validated['itinerary'])
            ? array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', $validated['itinerary'])))
            : [];

        if (!empty($validated['languages'])) {
            $langs = array_map('trim', explode(',', $validated['languages']));
            $validated['languages'] = json_encode($langs);
        } else {
            $validated['languages'] = null;
        }

        $validated['highlights'] = json_encode($validated['highlights']);
        $validated['included'] = json_encode($validated['included']);
        $validated['excluded'] = json_encode($validated['excluded']);
        $validated['itinerary'] = json_encode($validated['itinerary']);

        return $validated;
    }
}
