@extends('layouts.app')
@section('content')
        <!-- Validation Errors -->

        <form method="POST" action="{{ route('password.update') }}" class="content">
            @csrf
            <!-- Password Reset Token -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <div class="field">
                <label class="field--label">E-mail</label>
                <div class="field--data">
                    <input id="email" class="block mt-1 w-full" id="email" class="block mt-1 w-full" type="email" name="email" value="{{old('email', $request->email)}}" required autofocus >
                </div>
            </div>
            <div class="field">
                <label class="field--label">Пароль</label>
                <div class="field--data with-image">
                    <input id="password"
                           type="password"
                           name="password"
                           required autocomplete="current-password" value="">
                    <span class="private" onclick="showPassword(this)"></span>
                </div>
            </div>
            <div class="field">
                <label class="field--label">Повторите пароль</label>
                <div class="field--data with-image">
                    <input id="password_confirmation" class="block mt-1 w-full"
                           type="password"
                           name="password_confirmation" required value="">
                    <span class="private" onclick="showPassword(this)"></span>
                </div>
            </div>
            <x-auth-validation-errors class="mb-4" :errors="$errors" />
            <div class="field">
                <button class="button primary">
                    Сменить пароль
                </button>
            </div>
        </form>
@endsection
