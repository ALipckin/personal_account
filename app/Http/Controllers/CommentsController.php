<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class CommentsController
{
    public function index(Request $request) {
        $perPage = $request->input('per_page', 4);  // Количество комментариев на странице
        $search = $request->input('search');  // Параметр поиска
        $sort = $request->input('sort', 'asc');  // Направление сортировки по умолчанию 'asc'

        // Создаем запрос для получения комментариев
        $commentsQuery = Comment::query();

        // Применяем поиск, если он есть
        if ($search) {
            $commentsQuery->where('title', 'LIKE', '%' . $search . '%')
                ->orWhere('text', 'LIKE', '%' . $search . '%');
        }

        // Применяем сортировку по дате
        $commentsQuery->orderBy('created_at', $sort);

        // Пагинация
        $comments = $commentsQuery->paginate($perPage);

        return view('comments', compact('comments'));
    }
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'text' => 'required|string|max:1000',
                'recommended' => 'nullable|boolean',
            ]);
            $validatedData['user_id'] = Auth::id();
            $comment = new Comment();
            $comment->fill($validatedData);
            $comment->save();

            return response()->json([
                'message' => 'Comment created successfully',
                'comment' => $comment,
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Обработка ошибок валидации
            return response()->json([
                'status' => 'Ошибка валидации',
                'message' => $e->errors(),
                'status_code' => 422
            ], 422);
        }
    }
}
