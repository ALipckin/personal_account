<div id="popup-comment" class="add-comment popup-comment no-display">
    <div class="comment-form">
        <div class="popup--title">
            Отзыв
            <div class="close pointer" onclick="closePopup()">
                <img src="{{ asset('image/close.svg') }}">
            </div>
        </div>
        <div class="comment--info">
            <div class="person">
                <div class="comment--person-icon">
                    <span class="person--icon">
                        <img src="{{ asset('image/Union.png') }}">
                    </span>
                </div>
                <span class="person--nickname">{{ $nickname ?? null }}</span>
            </div>
            <div class="comment--title">
                {{ $commentTitle ?? null }}
            </div>
            <div class="comment--data">
                {{ $commentText ?? null }}
            </div>
            @if($isRecommended ?? null)
                <div class="recommend">
                    <img src="{{ asset('image/mdi_thumb-up-outline.svg') }}">
                    <div>
                        <div class="nickname">{{ $nickname ?? null }}</div>
                        <div class="status">рекомендует</div>
                    </div>
                </div>
            @else
                <div class="recommend no-recommend">
                    <img src="{{ asset('image/mdi_thumb-up-outline-red.svg') }}">
                    <div>
                        <div class="nickname">{{ $nickname ?? null }}</div>
                        <div class="status">нерекомендует</div>
                    </div>
                </div>
            @endif
        </div>
        <div class="comment--footer buttons">
            <div class="button" onclick="closePopup()">Назад</div>
        </div>
    </div>
</div>
<script>
    function openFullCommentModal(nickname, photoPath, title, text) {
        // Заполняем модальное окно данными
        document.querySelector('#popup-comment .person--nickname').textContent = nickname;
        document.querySelector('#popup-comment .comment--title').textContent = title;
        document.querySelector('#popup-comment .comment--data').textContent = text;
        document.querySelector('#popup-comment .comment--data').textContent = text;

        if(photoPath){
            document.querySelector('#popup-comment .comment--person-icon').innerHTML =
            `<img class="person--img" src=${photoPath}>`;
        }

        document.getElementById('popup-comment').classList.remove('no-display');
    }
</script>
