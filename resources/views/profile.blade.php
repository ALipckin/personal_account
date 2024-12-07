@extends('layouts.app')
@section('styles')
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
    <style>
        .person--img{
            width: 30px;
            height: 30px;
            border-radius: 50%;
        }
    </style>
@endsection
@section('content')
    @include('components.popup-comment')
<div class="content">
    <h2>Мой профиль</h2>
    <div class="profile">
        <form method="POST" action="{{route('profile.update')}}" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <div class="my-profile">
                <div class="photo">
                    @if(isset(Auth()->user()->photo))
                        <img class="photo" src="{{Auth()->user()->photo}}">
                    @endif
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
                    <div class="field--data with-image" id="curr-password-field">
                        <input class="password" type="password" name="password" value="" id="current_password" placeholder="Введите пароль">
                        <span class="private" onclick="showPassword(this)"></span>
                        <div class="error-message"></div>
                    </div>
                </div>
            </div>

            <div class="fields">
                <div class="field" >
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
                    <div class="field--data with-image" id="new-password-field">
                        <input class="password" type="password" id="new_password" name="new_password" value="" placeholder="Введите новый пароль">
                        <span class="private" onclick="showPassword(this)"></span>
                        <div class="error-message"></div>
                    </div>
                </div>
                <div class="field">
                    <label class="field--label">Подтверждение пароля</label>
                    <div class="field--data with-image" id="confirm-password-field">
                        <input class="password" type="password" id="confirm_password" name="confirm_password" value="" placeholder="Подтвердите новый пароль">
                        <span class="private" onclick="showPassword(this)"></span>
                        <div class="error-message"></div>
                    </div>
                </div>
                <button type="submit" class="button primary" id="save_password_btn">Сменить пароль</button>
            </div>

    </div>
    <h2>Мои отзывы</h2>
    @if(isset($myComments))
        @foreach($myComments as $comment)
            <div class="comment">
                <div class="person">
                    @if(isset($comment->user->photo))
                        <img class="person--img" src="{{$comment->user->photo}}">
                    @else
                        <span class="person--icon">
                        <img src="{{ asset('/image/Union.png') }}">
                    </span>
                    @endif
                    <span class="person--nickname">{{$comment->user->name}}</span>
                </div>
                <div class="date">
                    {{$comment->created_at->format('Y-m-d')}}
                </div>
                <div class="comment--title">
                    {{$comment->title}}
                </div>
                <div class="comment--data">
                    {{$comment->text}}
                </div>
                <div class="buttons">
                    <div class="button" onclick="openFullCommentModal('{{ $comment->user->name }}', '{{ $comment->title }}', '{{ $comment->text }}')">Читать весь отзыв</div>
                </div>
            </div>
        @endforeach
    @else
        Пока нет
    @endif

</div>
@endsection
@section('scripts')
    <script>
        function openFullCommentModal(nickname, title, text) {
            console.log("open modal")
            // Заполняем модальное окно данными
            document.querySelector('#popup-comment .person--nickname').textContent = nickname;
            document.querySelector('#popup-comment .comment--title').textContent = title;
            document.querySelector('#popup-comment .comment--data').textContent = text;
            document.querySelector('#popup-comment .comment--data').textContent = text;
            @if(isset($comment->user->photo))
                document.querySelector('#popup-comment .comment--person-icon').innerHTML =
                    '<img class="person--img" src="{{$comment->user->photo}}">';
            @endif
            // Показываем модальное окно
            document.getElementById('popup-comment').classList.remove('no-display');
        }

        document.getElementById('change-password-btn').addEventListener('click', function() {
            var currentPassword = document.getElementById('current_password').value;
            const passwordField = document.querySelector('#curr-password-field');
            const errorMessage = passwordField.querySelector('.error-message');
            errorMessage.textContent = "";
            passwordField.classList.remove('border-red');

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
                            // Добавляем класс для отображения ошибки
                            passwordField.classList.add('border-red');  // Добавляем красную рамку, например, для выделения ошибки

                            if (errorMessage) {
                                // Вставляем текст ошибки в div с классом error-message
                                errorMessage.textContent = data.error;  // Текст ошибки
                            }
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }
            else{
                // Добавляем класс для отображения ошибки
                passwordField.classList.add('border-red');  // Добавляем красную рамку, например, для выделения ошибки

                if (errorMessage) {
                    // Вставляем текст ошибки в div с классом error-message
                    errorMessage.textContent = "Введите пароль";  // Текст ошибки
                }
            }
        });

        document.getElementById('save_password_btn').addEventListener('click', function() {
            var newPassword = document.getElementById('new_password').value;
            var confirmPassword = document.getElementById('confirm_password').value;
            const newPassId = '#new-password-field';
            const confirmPassId = '#confirm-password-field';
            removeError(newPassId);
            removeError(confirmPassId);

            // Проверка, совпадают ли новые пароли
            if (newPassword !== confirmPassword) {
                setError(confirmPassId, 'Пароли не совпадают!');
                return;
            }

            fetch('{{ route("profile.password.change") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    current_password: document.getElementById('current_password').value,
                    new_password: newPassword
                })
            })
                .then(response => response.json())  // преобразуем ответ в JSON
                .then(data => {
                    if (data.status_code === 422) {  // если ошибка валидации
                        // Обрабатываем ошибку валидации для поля new_password
                        if (data.message && data.message.new_password) {
                            setError(newPassId, data.message.new_password[0]);  // отображаем сообщение
                        } else {
                            setError(newPassId, 'Неизвестная ошибка валидации');
                        }
                    } else if (data.success) {
                        alert('Пароль успешно изменен');
                        $('#new-password-fields').hide();
                    } else {
                        setError(newPassId, data.error || 'Произошла ошибка при изменении пароля');
                    }
                })
                .catch(error => {
                    setError(newPassId, error.message || 'Произошла ошибка');
                });
        });
    </script>
@endsection
