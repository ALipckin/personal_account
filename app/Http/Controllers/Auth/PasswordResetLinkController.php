<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        // Отправляем ссылку для сброса пароля
        $status = Password::sendResetLink(
            $request->only('email')
        );

        // Если ссылка для сброса пароля отправлена успешно, перенаправляем на страницу логина
        if ($status == Password::RESET_LINK_SENT) {
            return redirect()->route('auth.login')->with('status', __('A password reset link has been sent to your email.'));
        }

        // Если ошибка при отправке ссылки, возвращаем с ошибкой
        return back()->withInput($request->only('email'))
            ->withErrors(['email' => __($status)]);
    }
}
