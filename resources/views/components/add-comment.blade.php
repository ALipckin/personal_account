<div id="add-comment" class="comment-form add-comment no-display">
    <form id="commentForm" style="background-color: white; margin: 30px">
        <div class="popup--title">
            <div id="popup--title-text">Новый отзыв</div>
            <div class="close pointer" onclick="closePopup()">
                <img src="{{ asset('/image/close.svg') }}">
            </div>
        </div>
        <div class="comment--info">
            <input id="comment-id" type="text" hidden value="">
            <!-- Заголовок отзыва -->
            <div class="field" id="title-field">
                <label class="field--label">Заголовок отзыва одной фразой</label>
                <div class="field--data">
                    <input type="text" name="title" id="title" />
                </div>
                <div class="error-message"></div>
            </div>

            <!-- Текст отзыва -->
            <div class="field" id="text-field">
                <label class="field--label">Ваш отзыв</label>
                <textarea name="text" id="text" class="field--data" rows="20"></textarea>
                <div class="error-message"></div></div>

            <!-- Рекомендация -->
            <div class="field--radio" id="recommend-field" authorized>
                <label class="field--label">Вы бы порекомендовали это?</label>
                <div class="field--data">
                    <input type="radio" name="recommend" id="recommend-yes" value="1" />
                    <label for="recommend-yes">Да</label>
                </div>
                <div class="field--data">
                    <input type="radio" name="recommend" id="recommend-no" value="0" />
                    <label for="recommend-no">Нет</label>
                </div>
                <div class="error-message"></div>
            </div>
            <!-- Сообщение для неавторизованных пользователей -->
            <div class="field" not-authorized>
                Для того, чтобы оставить рекомендацию к отзыву,
                <a href="{{ route('auth.login') }}">войдите или зарегистрируйтесь</a>
            </div>
        </div>
        <!-- Footer -->
        <div class="comment--footer buttons">
            <button type="button" class="button primary" id="submitComment">Отправить отзыв</button>
            <div class="button" onclick="closePopup()">Назад</div>
        </div>
    </form>
</div>
<script src="{{ asset('/scripts/comments.js') }}"></script>
