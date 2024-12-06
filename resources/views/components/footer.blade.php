<link rel="stylesheet" href="{{asset('/css/footer.css')}}">
<footer id="footer" class="footer">
    <div class="left-block">
        <img src="{{ asset('image/H_7%20semibold.png') }}">
    </div>
    <div class="center">
        <div class="pointer" onclick="window.location.href='{{ route('home') }}'">Главная</div>
        <div class="pointer" onclick="window.location.href='{{ route('comments') }}'">Отзывы</div>
        <div class="pointer" authorized onclick="window.location.href='{{ route('profile.index') }}'">Мой профиль</div>
        <div class="pointer" onclick="window.location.href='{{ route('privacy.policy') }}'">Политика обработки персональных данных</div>
    </div>
    <div class="right-block">Logo Text © 2010 — 2023</div>
</footer>
