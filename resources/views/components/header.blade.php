<link rel="stylesheet" href="{{ asset('css/header.css') }}">
<header id="header" class="header">
    <div class="header--info">
        <div class="logo">
            logo text
        </div>
        <div class="right-block">
            <div class="button primary" onclick="openPopup()">
                <img class="add--icon" src="{{ asset('image/Plus.png') }}">
                <span class="add--text show-add-comment" onclick="createCommentPopUp()">Добавить отзыв</span>
            </div>

                <div class="button" onclick="window.location.href='{{ route('auth.login') }}'" not-authorized>
                    Войти
                </div>

                <div class="person pointer" onclick="openPersonPopup()" authorized>
                    @if(isset(auth()->user()->photo))
                        <img class="person--img" src="{{auth()->user()->photo}}">
                    @else
                        <span class="person--icon">
                        <img src="{{ asset('/image/Union.png') }}">
                    </span>
                    @endif
                    <span class="person--nickname">{{ Auth::user()->name ?? null }}</span>
                </div>
                <div class="person-popup no-display" id="person-popup">
                    <img class="arrow" src="{{ asset('image/arrow-wrapper.svg') }}">
                    <div class="person-popup--items">
                        <div class="item pointer" onclick="window.location.href='{{ route('profile.index') }}'" >
                            <img src="{{ asset('image/mdi_account-outline.svg') }}">
                            Мой профиль
                        </div>
                        <div class="item pointer" onclick="window.location.href='{{ route('privacy.policy') }}'">
                            <img src="{{ asset('image/mdi_account-outline.svg') }}">
                            Политика конфиденциальности
                        </div>
                        <div class="hr"></div>
                        <div class="item pointer" onclick="logout()">
                            <img src="{{ asset('image/mdi_exit-to-app.svg') }}">
                            Выйти
                        </div>
                    </div>
                </div>
        </div>
    </div>
</header>
<script>
    function logout() {
        fetch('/logout', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                '_token': '{{ csrf_token() }}' // передаем токен в теле запроса
            }),
        }).then(response => {
            if (response.ok) {
                window.location.href = '/';
            } else {
                console.error('Ошибка при выходе', response);
            }
        })
            .catch(error => {
                console.error('Произошла ошибка:', error);
            });
    }
</script>
