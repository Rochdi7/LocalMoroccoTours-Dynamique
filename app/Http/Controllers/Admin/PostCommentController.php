<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostComment;
use Illuminate\Http\Request;

class PostCommentController extends Controller
{
    // List all comments (for moderation)
    public function index()
    {
        $comments = PostComment::with('post', 'user', 'parent')
            ->latest('created_at')
            ->get();

        return view('admin.post_comments.index', compact('comments'));
    }

    // Show a single comment thread (optional)
    public function show(PostComment $postComment)
    {
        $replies = $postComment->replies()->with('user')->get();
        return view('admin.post_comments.show', compact('postComment', 'replies'));
    }

    // Approve a comment
    public function approve(PostComment $postComment)
    {
        $postComment->update(['is_approved' => true]);
        return back()->with('success', 'Comment approved.');
    }

    // Unapprove a comment
    public function unapprove(PostComment $postComment)
    {
        $postComment->update(['is_approved' => false]);
        return back()->with('success', 'Comment unapproved.');
    }

    // Delete a comment
    public function destroy(PostComment $postComment)
    {
        $postComment->delete();
        return back()->with('success', 'Comment deleted.');
    }
}
