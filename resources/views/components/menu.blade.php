<link rel="stylesheet" href="{{ asset('/css/menu.css') }}">

<div id="menu" class="menu">
    <div
        class="menu--item pointer {{ Route::currentRouteName() === 'home' ? 'active' : '' }}"
        onclick="window.location.href='{{ route('home') }}'">
        Главная
    </div>
    <div
        class="menu--item pointer {{ Route::currentRouteName() === 'comments' ? 'active' : '' }}"
        onclick="window.location.href='{{ route('comments') }}'">
        Отзывы
    </div>
    <div
        class="menu--item pointer {{ Route::currentRouteName() === 'profile' ? 'active' : '' }}"
        onclick="window.location.href='{{ route('profile') }}'" authorized>
        Мой профиль
    </div>
</div>

