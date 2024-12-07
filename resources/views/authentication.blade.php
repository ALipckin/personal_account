@extends('layouts.app')
@section('styles')
    <style>
        .error-message {
            color: red;
            font-size: 0.875em;
            margin-top: 0.25em;
        }
        .border-red{
            border-color:red !important;
        }
    </style>
@endsection
@section('content')
    <div class="content">
        <div class="popup">
            <div class="popup--tabs" id="popup-tabs">
                <div id="auth" class="tab pointer active">Вход</div>
                <div id="registration" class="tab pointer">Регистрация</div>
            </div>
            <form method="POST" action="{{ route('login')}}" id="auth-data" class="popup--fields">
                @csrf
                <div class="field">
                    <label class="field--label">E-mail</label>
                    <div class="field--data @error('email')border-red @enderror">
                        <input id="email"
                               type="email"
                               name="email"
                               value="{{ old('email') }}"
                               required autofocus>
                    </div>
                    @error('email')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
                <div class="field">
                    <label class="field--label">Пароль</label>
                    <div class="field--data with-image @error('password')border-red @enderror">
                        <input id="password"
                               type="password"
                               name="password"
                               class="password"
                               required autocomplete="current-password"
                               value="{{ old('password') }}">
                        <span class="private" onclick="showPassword(this)"></span>
                    </div>
                    @error('password')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
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
            <form id="registration-data" class="popup--fields no-display" method="POST" action="{{ route('register') }}">
                @csrf
                <div class="field">
                    <label class="field--label">Логин / Имя пользователя</label>
                    <div class="field--data @error('name') border-red @enderror">
                        <input id="name"
                               type="text"
                               name="name"
                               value="{{ old('name') }}"
                               required autofocus>
                    </div>
                    @error('name')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
                <div class="field">
                    <label class="field--label">E-mail</label>
                    <div class="field--data @error('email') border-red @enderror">
                        <input id="email"
                               type="email"
                               name="email"
                               value="{{ old('email') }}"
                               required>
                    </div>
                    @error('email')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
                <div class="field">
                    <label class="field--label">Пароль</label>
                    <div class="field--data with-image @error('password') border-red @enderror">
                        <input id="password"
                               type="password"
                               name="password"
                               class="password"
                               required autocomplete="new-password"
                               value="{{ old('password') }}">
                        <span class="private" onclick="showPassword(this, '#password')"></span>
                    </div>
                    @error('password')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
                <div class="field">
                    <label class="field--label">Повторите пароль</label>
                    <div class="field--data with-image @error('password_confirmation') border-red @enderror">
                        <input id="password_confirmation"
                               type="password"
                               class="password"
                               name="password_confirmation"
                               value="{{ old('password_confirmation') }}"
                               required>
                        <span class="private" onclick="showPassword(this, '#password_confirmation')"></span>
                    </div>
                    @error('password_confirmation')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
                <div class="field">
                    <input type="checkbox" id="consent"/>
                    <span>Я даю согласие на <a href="{{ route('privacy.policy') }}">обработку моих персональных данных</a></span>
                    <div class="error" id="error-message">Вы должны дать согласие на обработку персональных данных</div>
                </div>
                <div class="field">
                    <button class="button primary" id="register-button">
                        Зарегистрироваться
                    </button>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="{{ asset('scripts/authentication.js') }}">
    </script>
    <script>

    </script>
@endsection
