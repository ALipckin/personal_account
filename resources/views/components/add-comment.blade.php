<div class="comment-form">
    <div class="popup--title">
        Новый отзыв
        <div class="close pointer" onclick="closePopup()">
            <img src="{{ asset('/image/close.svg') }}">
        </div>
    </div>
    <div class="comment--info">
        <div class="field">
            <label class="field--label">Заголовок отзыва одной фразой</label>
            <div class="field--data">
                <input type="text" />
            </div>
        </div>
        <div class="field">
            <label class="field--label">Ваш отзыв</label>
            <textarea class="field--data" rows="20"></textarea>
        </div>
        @auth
            <div class="field--radio">
                <label class="field--label">Вы бы порекомендовали это?</label>
                <div class="field--data">
                    <input type="radio" name="recommend" />
                    <label>Да</label>
                </div>
                <div class="field--data">
                    <input type="radio" name="recommend" />
                    <label>Нет</label>
                </div>
            </div>
        @endauth
        @guest
            <div class="field">
                Для того, чтобы оставить рекомендацию к отзыву, <a href="{{ route('authentication') }}">войдите или зарегистрируйтесь</a>
            </div>
        @endguest
    </div>
    <div class="comment--footer buttons">
        <div class="button primary">Отправить отзыв</div>
        <div class="button" onclick="closePopup()">Назад</div>
    </div>
</div>
