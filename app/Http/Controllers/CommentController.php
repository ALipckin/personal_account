<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class CommentController
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

            // Получаем идентификатор авторизованного пользователя
            $userId = Auth::id();
            Log::info("user id = ". $userId);
            // Если пользователь авторизован, присваиваем его id в данных
            $validatedData['user_id'] = $userId ?? null;
            $validatedData['recommended'] = null;
            if (array_key_exists('recommended', $validatedData) && $userId) {
                Log::info("saving recommended");
                $validatedData['recommended'] = $validatedData['recommended'] ?? false;
            }

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
                'status' => 'Validation error',
                'message' => $e->errors(),
            ], 422);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            // Определяем правила валидации
            $validatedData = $request->validate([
                'title' => 'nullable|string|max:255', // Поля могут быть необязательными для обновления
                'text' => 'nullable|string|max:1000',
                'recommended' => 'nullable|boolean',
            ]);

            // Находим комментарий по id
            $comment = Comment::findOrFail($id);

            // Проверяем права пользователя (опционально)
            $userId = Auth::id();
            if ($comment->user_id !== $userId) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'You do not have permission to update this comment.',
                ], 403);
            }

            // Обновляем только переданные данные
            $comment->fill(array_filter($validatedData, function ($value) {
                return $value !== null; // Фильтруем только непустые значения
            }));

            $comment->save();

            return response()->json([
                'message' => 'Comment updated successfully',
                'comment' => $comment,
            ], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Обработка ошибок валидации
            return response()->json([
                'status' => 'Validation error',
                'message' => $e->errors(),
            ], 422);
        } catch (ModelNotFoundException $e) {
            // Если комментарий не найден
            return response()->json([
                'status' => 'Error',
                'message' => 'Comment not found',
            ], 404);
        } catch (\Exception $e) {
            // Обработка других ошибок
            return response()->json([
                'status' => 'Error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

}
