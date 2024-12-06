@extends('layouts.app')
@section('styles')
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endsection
@section('content')
<div class="content">
    <h2>Мой профиль</h2>
    <div class="profile">
        <form method="POST" action="{{route('profile.update')}}" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <div class="my-profile">
                <div class="photo">
                    <img class="photo" src="{{Auth()->user()->photo ?? null}}">
                </div>
                <div class="info">
                    <div class="info--nickname">{{Auth()->user()->name}}</div>
                    <div>ID: {{Auth()->user()->id}}</div>
                        <div class="input-group info--update-photo pointer">
                            <div class="custom-file">
                                <input hidden type="file" class="custom-file" id="photo" name="photo">
                                <label class="custom-file" for="photo">Заменить фото</label>
                            </div>
                            @error('photo')
                            <div class="text-danger">{{$message}}</div>
                            @enderror
                        </div>
                </div>
            </div>
            <div class="update-data">
            <div class="fields">
                <div class="field">
                    <label class="field--label">Логин / Имя пользователя</label>
                    <div class="field--data">
                        <input type="text" name="name" value="{{ old('name', Auth()->user()->name) }}">
                        @error('name')
                        <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="field">
                    <label class="field--label">Пароль</label>
                    <div class="field--data with-image">
                        <input type="password" name="password" value="" id="current_password" placeholder="Введите пароль">
                        <span class="private" onclick="showPassword(this)"></span>
                        @error('password')
                        <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="fields">
                <div class="field">
                    <label class="field--label">E-mail</label>
                    <div class="field--data">
                        <input type="text" name="email" value="{{ old('email', Auth()->user()->email) }}">
                        @error('email')
                        <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            </div>
            <div class="buttons">
                <button type="submit" class="button primary">Сохранить</button>
                <div class="button" id="change-password-btn" id="change-password-btn">Сменить пароль</div>
            </div>
        </form>
            <!-- Поля для нового пароля и подтверждения пароля, скрытые по умолчанию -->
            <div id="new-password-fields" style="display: none;">
                <div class="field">
                    <label class="field--label">Новый пароль</label>
                    <div class="field--data with-image">
                        <input type="password" id="new_password" name="new_password" value="" placeholder="Введите новый пароль">
                        <span class="private" onclick="showPassword(this)"></span>
                        @error('new_password')
                        <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="field">
                    <label class="field--label">Подтверждение пароля</label>
                    <div class="field--data with-image">
                        <input type="password" id="confirm_password" name="confirm_password" value="" placeholder="Подтвердите новый пароль">
                        <span class="private" onclick="showPassword(this)"></span>
                        @error('confirm_password')
                        <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <button type="submit" class="button primary" id="save_password_btn">Сменить пароль</button>
            </div>

    </div>
    <h2>Мои отзывы</h2>
    <div class="comment">
    @if(isset($myComments))
        @foreach($myComments as $comment)

            <div class="person">
                <span class="person--icon">
                    <img src="{{asset('/image/Union.png')}}">
                </span>
                <span class="person--nickname">{{$comment->user->name}}</span>
            </div>
            <div class="date">
                {{$comment->user->timestamp}}
            </div>
            <div class="comment--title">
                {{$comment->user->title}}
            </div>
            <div class="comment--data">
                {{$comment->user->text}}
            </div>
            <div class="buttons">
                <div class="button">Читать весь отзыв</div>
            </div>
      @endforeach
    @else
        Пока нет
    @endif
    </div>

</div>
@endsection
@section('scripts')
    <script>
        document.getElementById('change-password-btn').addEventListener('click', function() {
            var currentPassword = document.getElementById('current_password').value;

            if(currentPassword) {
                // Проверка текущего пароля через AJAX
                fetch('{{ route("profile.password.check") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        // Обязательно передаем CSRF-токен
                    },
                    body: JSON.stringify({
                        current_password: currentPassword
                    })
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Если пароль правильный, показываем поля для ввода нового пароля
                            document.getElementById('new-password-fields').style.display = 'block';
                        } else {
                            alert(data.error);  // Показать ошибку, если пароль неверный
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }
            else{
                alert("Введите пароль")
            }
        });

        document.getElementById('save_password_btn').addEventListener('click', function() {
            var newPassword = document.getElementById('new_password').value;
            var confirmPassword = document.getElementById('confirm_password').value;
            // Проверка, совпадают ли новые пароли
            if (newPassword !== confirmPassword) {
                alert('Пароли не совпадают!');
                return;
            }

            // Отправка нового пароля на сервер
            fetch('{{ route("profile.password.change") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    // Обязательно передаем CSRF-токен
                },
                body: JSON.stringify({
                    current_password: document.getElementById('current_password').value,
                    new_password: newPassword
                })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Пароль успешно изменен');
                        document.getElementById('new-password-fields').style.display = 'none';
                    } else {
                        alert(data.error);  // Показать ошибку, если смена пароля не удалась
                    }
                })
                .catch(error => console.error('Error:', error));
        });
    </script>
@endsection
