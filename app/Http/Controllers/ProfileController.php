<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UpdateRequest;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    public function update(UpdateRequest $request)
    {
        $data = $request->validated();

        // Получаем текущего пользователя
        $user = Auth::user();

        // Получаем файл из запроса
        $file = $request->file('photo');
        $filename = null;  // Инициализируем переменную для имени файла

        if (!empty($file)) {
            // Генерируем уникальное имя для файла
            $filename = $user->id . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/img/photo/', $filename);
        }

        // Создаем массив с данными для обновления
        $updateData = [];

        // Обновляем только те поля, которые не пустые
        if (!empty($data['email'])) {
            $updateData['email'] = $data['email'];
        }
        if (!empty($data['name'])) {
            $updateData['name'] = $data['name'];
        }
        if ($filename) {
            $updateData['photo'] = '/storage/img/photo/' . $filename;
        }

        // Обновляем данные пользователя
        $user->update($updateData);

        return view('profile');
    }

    public function index()
    {
        $myComments = Comment::where('user_id', Auth::id())->get();
        return view('profile', compact('myComments'));
    }

    // Функция для проверки текущего пароля
    public function checkMyPassword(Request $request)
    {
        // Валидируем текущий пароль
        $request->validate([
            'current_password' => 'required|string',
        ]);

        // Получаем пользователя
        $user = Auth::user();

        // Проверяем, совпадает ли текущий пароль с хешированным
        if (Hash::check($request->input('current_password'), $user->password)) {
            return response()->json(['success' => true], 200);
        } else {
            return response()->json(['error' => 'Неверный текущий пароль'], 401);
        }
    }

    // Функция для изменения пароля
    public function changeMyPassword(Request $request)
    {
        try {
            // Валидация нового пароля и его подтверждения
            $request->validate([
                'current_password' => 'required|string',
                'new_password' => 'required|string|min:2',  // Минимальная длина пароля
            ]);

            // Получаем пользователя
            $user = Auth::user();

            // Проверяем текущий пароль
            if (!Hash::check($request->input('current_password'), $user->password)) {
                return response()->json([
                    'status' => 'Неверный текущий пароль',
                    'status_code' => 400
                ], 400);
            }

            // Обновляем пароль пользователя
            $user->password = bcrypt($request->input('new_password'));
            $user->save();

            return response()->json([
                'success' => 'Пароль успешно изменен',
                'status_code' => 200
            ], 200);
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
