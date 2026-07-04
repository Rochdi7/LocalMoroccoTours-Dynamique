<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\BlogCategory;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('author', 'category')->latest()->paginate(10);
        return view('admin.posts.index', compact('posts'));
    }

    public function create()
    {
        $categories = BlogCategory::all();
        $tags = Tag::all();

        return view('admin.posts.create', compact('categories', 'tags'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'excerpt' => 'nullable|string',
            'quote' => 'nullable|string',
            'content' => 'required',
            'featured_image' => 'nullable|image|max:2048',
            'status' => 'required|in:draft,published',
            'category_id' => 'nullable|exists:blog_categories,id',
            'tags' => 'array|nullable',
            'tags.*' => 'exists:tags,id',
        ]);

        $slug = $this->generateUniqueSlug(Str::slug($request->title));

        $post = Post::create([
            'title' => $request->title,
            'slug' => $slug,
            'excerpt' => $request->excerpt,
            'quote' => $request->quote,
            'content' => $request->content,
            'status' => $request->status,
            'author_id' => Auth::id(),
            'category_id' => $request->category_id,
            'published_at' => $request->status === 'published' ? now() : null,
        ]);

        if ($request->hasFile('featured_image')) {
            $post->addMediaFromRequest('featured_image')
                ->toMediaCollection('featured_image');
        }

        if ($request->filled('tags')) {
            $post->tags()->sync($request->tags);
        }

        return redirect()->route('admin.posts.index')
            ->with('success', 'Post created successfully.');
    }

    public function edit(Post $post)
    {
        $categories = BlogCategory::all();
        $tags = Tag::all();

        return view('admin.posts.edit', compact('post', 'categories', 'tags'));
    }

    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'required|max:255',
            'excerpt' => 'nullable|string',
            'quote' => 'nullable|string',
            'content' => 'required',
            'featured_image' => 'nullable|image|max:2048',
            'status' => 'required|in:draft,published',
            'category_id' => 'nullable|exists:blog_categories,id',
            'tags' => 'array|nullable',
            'tags.*' => 'exists:tags,id',
        ]);

        // Check if title changed and update slug if needed
        if ($request->title !== $post->title) {
            $slug = $this->generateUniqueSlug(Str::slug($request->title));
        } else {
            $slug = $post->slug;
        }

        $post->update([
            'title' => $request->title,
            'slug' => $slug,
            'excerpt' => $request->excerpt,
            'quote' => $request->quote,
            'content' => $request->content,
            'status' => $request->status,
            'category_id' => $request->category_id,
            'published_at' => $request->status === 'published' && $post->published_at === null
                ? now()
                : $post->published_at,
        ]);

        if ($request->hasFile('featured_image')) {
            $post->clearMediaCollection('featured_image');
            $post->addMediaFromRequest('featured_image')
                ->toMediaCollection('featured_image');
        }

        $post->tags()->sync($request->tags ?? []);

        return redirect()->route('admin.posts.index')
            ->with('success', 'Post updated successfully.');
    }

    public function destroy(Post $post)
    {
        $post->clearMediaCollection('featured_image');
        $post->tags()->detach();
        $post->delete();

        return redirect()->route('admin.posts.index')
            ->with('success', 'Post deleted.');
    }

    private function generateUniqueSlug($slug)
    {
        $originalSlug = $slug;
        $count = 1;

        while (Post::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }

        return $slug;
    }

    public function uploadImage(Request $request)
    {
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('uploads/posts', 'public');

            return response()->json([
                'success' => true,
                'url' => asset('storage/' . $path),
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'No image uploaded.',
        ], 400);
    }
}
