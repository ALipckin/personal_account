<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function update(UpdateRequest $request){
        $data = $request->validate();

        // Получаем текущего пользователя
        $user = Auth::user();

        // Получаем файл из запроса
        $file = $request->file('photo');
        // Генерируем уникальное имя для файла
        $filename = $user->id . '.' . $file->getClientOriginalExtension();

        $file->storeAs('public/img/photo/', $filename);

        // Обновляем данные
        $user->update([
            'email' => $data['email'],
            'name' => $data['name'],
            'password' => isset($data['password']) ? bcrypt($data['password']) : $user->password,  // Если пароль был передан, хешируем его
            'photo' => '/storage/img/photo/' . $filename
        ]);

        // Возвращаем ответ, например, с подтверждением успешного обновления
        return response()->json(['message' => 'Данные успешно обновлены']);
    }

    public function uploadPhoto(Request $request)
    {
        // Валидация входящего файла
        $validated = $request->validate([
             // Ограничение на тип и размер файла
        ]);


        return response()->json([
            'message' => 'Фото профиля успешно загружено',
            'profile_picture_url' => asset('storage/img/photo/' . $filename),
        ], 200);
    }
}
