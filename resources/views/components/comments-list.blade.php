@foreach($comments as $comment)
    <div class="comment">
        <div class="person">
            @if(isset($comment->user->photo))
                <img class="person--img" src="{{$comment->user->photo}}">
            @else
                <span class="person--icon">
                    <img src="{{ asset('image/Union.png') }}">
                </span>
            @endif
            <span class="person--nickname">{{$comment->user->name ?? "Гость"}}</span>
        </div>
        <div class="date">
            {{$comment->created_at->format('Y-m-d')}}
        </div>
        <div class="comment--title">
            {{$comment->title}}
        </div>
        <div class="comment--data" id="comment-{{$comment->id}}">
            @php
                $commentText = $comment->text;
                // Ограничиваем длину текста до 350 символов для начального отображения
                $shortText = mb_substr($commentText, 0, 350);
            @endphp

            <div class="comment-text">
                {{-- Печать ограниченного текста --}}
                {!! nl2br(e($shortText)) !!}
            </div>

        </div>

        <div class="buttons">
            {{-- Кнопка редактирования только для авторизованных пользователей и если это их комментарий --}}
            @if(isset(auth()->user()->id) && $comment->user_id == auth()->user()->id)
                <div class="button with-image" onclick="updateComment('{{ $comment->id ?? "Гость" }}',
            '{{ addslashes($comment->title) }}',
            '{{ str_replace(["\r\n", "\r", "\n"], "<br />", $comment->text) }}',
            '{{ $comment->recommended }}')">
                    <img src="./image/Review.svg">
                    Редактировать отзыв
                </div>
            @endif

            {{-- Кнопка "Читать весь отзыв", если текст больше 350 символов или более 3 строк --}}
            <div class="button" id="read-more-{{$comment->id}}" style="display:none;" onclick="openFullCommentModal(
    '{{ e($comment->user->name ?? "Гость") }}',
    '{{ $comment->user->photo ?? null }}',
    '{{ addslashes($comment->title) }}',
    '{{ str_replace(["\r\n", "\r", "\n"], "<br />", $comment->text)}}')">
                Читать весь отзыв
            </div>
        </div>
    </div>
@endforeach
<script src="{{ asset('scripts/comments.js') }}"></script>
<script>
    function openFullCommentModal(nickname, photoPath, title, text) {
        // Заполняем модальное окно данными
        document.querySelector('#popup-comment .person--nickname').textContent = nickname;
        document.querySelector('#popup-comment .comment--title').textContent = title;

        // Используем innerHTML, чтобы отобразить текст с тегами <br />
        document.querySelector('#popup-comment .comment--data').innerHTML = text;

        if (photoPath) {
            document.querySelector('#popup-comment .comment--person-icon').innerHTML =
                `<img class="person--img" src="${photoPath}">`;
        }

        document.getElementById('popup-comment').classList.remove('no-display');
    }

    function handleSearch(event) {
        if (event.key === 'Enter') {
            const searchQuery = event.target.value.trim(); // Получаем текст из input
            if (searchQuery) {
                // Перенаправляем на URL с параметром поиска
                window.location.href = `/comments?search=${encodeURIComponent(searchQuery)}`;
            }
        }
    }

    document.addEventListener("DOMContentLoaded", function () {
        // Функция для подсчета количества <br> тегов в элементе
        function countBreaks(element) {
            // Получаем HTML содержимое элемента
            const htmlContent = element.innerHTML;

            // Считаем количество <br> тегов
            const breaks = (htmlContent.match(/<br>/g) || []).length;

            return breaks;
        }

        // Для каждого отзыва, проверяем количество <br> тегов
        @foreach($comments as $comment)
        const commentTextElement_{{$comment->id}} = document.getElementById('comment-{{$comment->id}}');
        const readMoreButton_{{$comment->id}} = document.getElementById('read-more-{{$comment->id}}');

        // Получаем количество <br> тегов в тексте
        const breaksCount_{{$comment->id}} = countBreaks(commentTextElement_{{$comment->id}});
        // Показываем кнопку "Читать весь отзыв", если есть больше 2-х <br> тегов (т.е. более 3 строк)
        if (breaksCount_{{$comment->id}} >= 3 || commentTextElement_{{$comment->id}}.textContent.length > 350) {
            readMoreButton_{{$comment->id}}.style.display = 'block';
            // Показываем троеточие только если текст был обрезан
            const dots = commentTextElement_{{$comment->id}}.querySelector('.dots');
            if (dots) {
                dots.style.display = 'inline';
            }
        }
        @endforeach
    });
</script>
