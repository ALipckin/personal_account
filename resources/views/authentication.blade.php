@extends('layouts.app')
@section('content')
    <div class="content">
        <div class="popup">
            <div class="popup--tabs" id="popup-tabs">
                <div id="auth" class="tab pointer active">Вход</div>
                <div id="registration" class="tab pointer">Регистрация</div>
            </div>
            <!-- Validation Errors -->
            <x-auth-validation-errors class="mb-4" :errors="$errors" />
            <form method="POST" action="{{ route('login') }}" id="auth-data" class="popup--fields">
                @csrf
                <div class="field">
                    <label class="field--label">E-mail</label>
                    <div class="field--data">
                        <input id="email" class="block mt-1 w-full" type="email" name="email" required autofocus value="{{old('email')}}">
                    </div>
                </div>
                <div class="field">
                    <label class="field--label">Пароль</label>
                    <div class="field--data with-image">
                        <input id="password"
                               type="password"
                               name="password"
                               required autocomplete="current-password" value="{{old('password')}}">
                        <span class="private" onclick="showPassword(this)"></span>
                    </div>
                </div>
                <div class="field text-right">
                    <a href="{{ route('password.recovery') }}">Забыли пароль?</a>
                </div>
                <div class="field">
                    <button class="button primary">
                        Войти
                    </button>
                </div>
            </form>
            <x-auth-validation-errors class="mb-4" :errors="$errors" />
            <form id="registration-data" class="popup--fields no-display"  method="POST" action="{{ route('register') }}">
                @csrf
                <div class="field">
                    <label class="field--label">Логин / Имя пользователя</label>
                    <div class="field--data">
                        <input id="name" type="text" name="name" :value="old('name')" required autofocus >
                    </div>
                </div>
                <div class="field">
                    <label class="field--label">E-mail</label>
                    <div class="field--data">
                        <input id="email" type="email" name="email" :value="old('email')" required >
                    </div>
                </div>
                <div class="field">
                    <label class="field--label">Пароль</label>
                    <div class="field--data with-image">
                        <input id="password"
                               type="password"
                               name="password"
                               required autocomplete="new-password" >
                        <span class="private" onclick="showPassword(this)"></span>
                    </div>
                </div>
                <div class="field">
                    <label class="field--label">Повторите пароль</label>
                    <div class="field--data with-image">
                        <input id="password_confirmation"
                               type="password"
                               name="password_confirmation" required>
                        <span class="private" onclick="showPassword(this)"></span>
                    </div>
                </div>
                <div class="field">
                    <input type="checkbox" />
                    <span>Я даю согласие на <a href="{{ route('privacy.policy') }}">обработку моих персональных данных</a></span>
                </div>
                <div class="field">
                    <button class="button primary">
                        Зарегистрироваться
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('scripts/authentication.js') }}"></script>
@endsection
