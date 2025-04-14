<?php

namespace App\Http\Controllers;

use App\Http\Requests\Comments\StoreRequest;
use App\Http\Requests\Comments\UpdateRequest;
use App\Models\Comment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController
{
    public function index(Request $request) {
        $perPage = $request->input('per_page', 4);
        $search = $request->input('search');
        $sort = $request->input('sort', 'asc');

        $commentsQuery = Comment::query();

        if ($search) {
            $commentsQuery->where('title', 'LIKE', '%' . $search . '%')
                ->orWhere('text', 'LIKE', '%' . $search . '%');
        }

        $commentsQuery->orderBy('created_at', $sort);

        $comments = $commentsQuery->paginate($perPage);

        return view('comments', compact('comments'));
    }
    public function store(StoreRequest $request): JsonResponse
    {
        $validatedData = $request->validated();
        $userId = Auth::id();

        $validatedData['user_id'] = $userId ?? null;
        $validatedData['recommended'] = null;
        if (array_key_exists('recommended', $validatedData) && $userId) {
            $validatedData['recommended'] = $validatedData['recommended'] ?? false;
        }

        $comment = new Comment();
        $comment->fill($validatedData);
        $comment->save();

        return response()->json([
            'message' => 'Comment created successfully',
            'comment' => $comment,
        ], 201);
    }

    public function update(UpdateRequest $request, $id): JsonResponse
    {
        $validatedData = $request->validated();

        $comment = Comment::findOrFail($id);

        $userId = Auth::id();
        if ($comment->user_id !== $userId) {
            return response()->json([
                'status' => 'error',
                'message' => 'You do not have permission to update this comment.',
            ], 403);
        }

        $comment->fill(array_filter($validatedData, function ($value) {
            return $value !== null;
        }));

        $comment->save();

        return response()->json([
            'message' => 'Comment updated successfully',
            'comment' => $comment,
        ], 200);
    }
}
