<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SpecialOffer;
use Illuminate\Http\Request;

class SpecialOfferController extends Controller
{
    public function index()
    {
        $offers = SpecialOffer::orderBy('order')->get();
        return view('admin.special_offers.index', compact('offers'));
    }

    public function create()
    {
        return view('admin.special_offers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'required|string|max:255',
            'text' => 'nullable|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'image_alt' => 'nullable|string|max:255',
            'image_title' => 'nullable|string|max:255',
            'image_caption' => 'nullable|string|max:255',
            'link' => 'nullable|url|max:255',
            'order' => 'nullable|numeric|min:0',
            'is_active' => 'sometimes|boolean',
        ]);

        // Create the special offer excluding non-column fields
        $specialOffer = SpecialOffer::create(
            $request->except('image', 'image_alt', 'image_title', 'image_caption', 'is_active')
        );

        // Set is_active based on checkbox presence
        $specialOffer->is_active = $request->has('is_active');
        $specialOffer->save();

        // Attach the uploaded image to media collection with SEO custom properties
        if ($request->hasFile('image')) {
            $specialOffer->addMediaFromRequest('image')
                ->withCustomProperties($this->imageSeoProperties($request, $specialOffer))
                ->toMediaCollection('special_offers');
        }

        return redirect()->route('admin.special-offers.index')->with('success', 'Special offer created successfully.');
    }

    public function edit(SpecialOffer $specialOffer)
    {
        return view('admin.special_offers.edit', compact('specialOffer'));
    }

    public function update(Request $request, SpecialOffer $specialOffer)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'required|string|max:255',
            'text' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'image_alt' => 'nullable|string|max:255',
            'image_title' => 'nullable|string|max:255',
            'image_caption' => 'nullable|string|max:255',
            'link' => 'nullable|url|max:255',
            'order' => 'nullable|numeric|min:0',
            'is_active' => 'sometimes|boolean',
        ]);

        $data = $request->except('image', 'image_alt', 'image_title', 'image_caption');
        $data['is_active'] = $request->has('is_active');

        $specialOffer->update($data);

        if ($request->hasFile('image')) {
            // New image uploaded: replace media and set SEO custom properties
            $specialOffer->clearMediaCollection('special_offers');
            $specialOffer->addMediaFromRequest('image')
                ->withCustomProperties($this->imageSeoProperties($request, $specialOffer))
                ->toMediaCollection('special_offers');
        } elseif ($media = $specialOffer->getFirstMedia('special_offers')) {
            // Keep existing image: just update its SEO custom properties
            $props = $this->imageSeoProperties($request, $specialOffer);
            $media->setCustomProperty('alt', $props['alt']);
            $media->setCustomProperty('title', $props['title']);
            $media->setCustomProperty('caption', $props['caption']);
            $media->save();
        }

        return redirect()->route('admin.special-offers.index')->with('success', 'Special offer updated successfully.');
    }

    /**
     * Build the SEO custom properties for the offer image.
     * Alt/title fall back to the offer title so the image is never left without alt text.
     */
    private function imageSeoProperties(Request $request, SpecialOffer $specialOffer): array
    {
        $alt = $request->filled('image_alt') ? $request->input('image_alt') : $specialOffer->title;

        return [
            'alt'     => $alt,
            'title'   => $request->filled('image_title') ? $request->input('image_title') : $alt,
            'caption' => $request->input('image_caption'),
        ];
    }

    public function destroy(SpecialOffer $specialOffer)
    {
        // Delete media and the offer record
        $specialOffer->clearMediaCollection('special_offers');
        $specialOffer->delete();

        return redirect()->route('admin.special-offers.index')->with('success', 'Special offer deleted successfully.');
    }
}
