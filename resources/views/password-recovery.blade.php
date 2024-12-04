@extends('layouts.app')
@section('content')
    <div class="content">
        <div class="popup">
            <div class="popup--info">
                <h2>Восстановление пароля</h2>
                <div>Введите свою почту и мы отправим Вам ссылку на восстановление пароля</div>
            </div>
            <div id="auth-data" class="popup--fields">
                <div class="field">
                    <label class="field--label">E-mail</label>
                    <div class="field--data">
                        <input type="text" value="">
                    </div>
                </div>
                <div class="field buttons">
                    <div class="button">
                        Назад
                    </div>
                    <div class="button primary">
                        Далее
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
