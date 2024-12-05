<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;


class CommentsController
{
    public function index(Request $request){
        $perPage = $request->input('per_page', 4);
        $search = $request->input('search');

        $comments = Comment::query()
            ->when($search, function ($query) use ($search) {
                $query->where('title', 'LIKE', '%' . $search . '%')
                    ->orWhere('text', 'LIKE', '%' . $search . '%');
            })
            ->paginate($perPage);

        return view('comments', compact('comments'));
    }
}
