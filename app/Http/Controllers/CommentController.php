<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, $id)
    {
        $request->validate([
            'type' => 'required|in:like,dislike',
            'comment' => 'required|string|max:500',
        ]);

        Comment::create([
            'celebrity_id' => $id,
            'type' => $request->input('type'),
            'comment' => $request->input('comment'),
        ]);

        return redirect()->back()->with('success', 'コメントを投稿しました！');
    }
}