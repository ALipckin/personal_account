@extends('layouts.app')
@section('content')
    <div class="content">
        <div class="popup">
            <div class="popup--info">
                <h2>Восстановление пароля</h2>
                <div>Введите свою почту и мы отправим Вам ссылку на восстановление пароля</div>
            </div>
            <!-- Validation Errors -->
            <x-auth-validation-errors class="mb-4" :errors="$errors" />
            <form method="POST" action="{{ route('password.email') }}" id="auth-data" class="popup--fields">
                @csrf
               <div class="field">
                    <label class="field--label">E-mail</label>
                    <div class="field--data">
                        <input id="email" class="block mt-1 w-full" type="email" name="email"
                               required autofocus>
                    </div>
                </div>
                <div class="field buttons">
                    <div class="button">
                        Назад
                    </div>
                    <button class="button primary">
                        Далее
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
