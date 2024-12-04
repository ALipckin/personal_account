@extends('layouts.app')
@section('styles')
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endsection
@section('content')
<div class="content">
    <h2>Мой профиль</h2>

    <div class="profile">
        <form method="POST" action="{{route('profile')}}" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <div class="my-profile">
                <div class="photo">
                    <img src="{{Auth()->user()->photo}}">
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
                        <input type="password" name="password" value="" placeholder="Введите новый пароль">
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
                <div class="button">Сменить пароль</div>
            </div>
        </form>
    </div>
    <h2>Мои отзывы</h2>
    <div class="comment">
        <div class="person">
                            <span class="person--icon">
                                <img src="{{asset('/image/Union.png')}}">
                            </span>
            <span class="person--nickname">Nickname</span>
        </div>
        <div class="date">
            07.10.2022
        </div>
        <div class="comment--title">
            Прототип нового сервиса — это как треск разлетающихся скреп!
        </div>
        <div class="comment--data">
            Вот вам яркий пример современных тенденций — постоянное информационно-пропагандистское обеспечение нашей деятельности не оставляет шанса для новых принципов формирования материально-технической и кадровой базы. Мы вынуждены отталкиваться от того, что сплочённость команды профессионалов говорит о возможностях существующих финансовых и административных условий. И нет сомнений, что базовые сценарии поведения пользователей функционально разнесены на независимые элементы.
        </div>
        <div class="buttons">
            <div class="button">Читать весь отзыв</div>
        </div>
    </div>
</div>
@endsection
