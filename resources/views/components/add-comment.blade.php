<div id="add-comment" class="comment-form add-comment no-display">
    <form id="commentForm" style="background-color: white; margin: 30px">
        <div class="popup--title">
            Новый отзыв
            <div class="close pointer" onclick="closePopup()">
                <img src="{{ asset('/image/close.svg') }}">
            </div>
        </div>
        <div class="comment--info">
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
<script>
    document.getElementById('submitComment').addEventListener('click', async () => {
        const titleFieldId = '#title-field';
        const textFieldId = '#text-field';
        const recommendFieldId = '#recommend-field';

        // Убираем старые ошибки
        removeError(titleFieldId);
        removeError(textFieldId);
        removeError(recommendFieldId);

        const titleValue = $(`${titleFieldId} input`).val();
        const textValue = $(`${textFieldId} textarea`).val();
        const recomendedValue = $(`${recommendFieldId} input[name="recommend"]:checked`).val(); // Для поля "Рекомендация"

        try {
            const response = await fetch('{{ route("comment.create") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    title: titleValue,
                    text: textValue,
                    recomended: recomendedValue,
                })
            });

            const data = await response.json();

            if (data.status_code === 422) {  // если ошибка валидации
                const errors = data.message; // получаем объект с ошибками

                // Устанавливаем ошибки для каждого поля, если они есть
                if (errors.title) {
                    setError(titleFieldId, errors.title[0]); // Устанавливаем первую ошибку для title
                }
                if (errors.text) {
                    setError(textFieldId, errors.text[0]); // Устанавливаем первую ошибку для text
                }
                if (errors.recommended) {
                    setError(recommendFieldId, errors.recommended[0]); // Устанавливаем первую ошибку для recommend
                }
            } else {
                closePopup();
            }
        } catch (error) {
            alert('Произошла ошибка: ' + (error.message || 'Неизвестная ошибка'));
        }
    });
</script>

