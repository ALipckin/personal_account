@section('styles')
    <link rel="stylesheet" href="{{ asset('css/comments.css') }}">
@endsection

@extends('layouts.app')

@section('content')
    @include('components.popup-comment')
    <div id="popup-comment" class="add-comment popup-comment modal no-display">
        <div class="comment-form">
            <div class="popup--title">
                Отзыв
                <div class="close pointer" onclick="closePopup()">
                    <img src="{{ asset('image/close.svg') }}">
                </div>
            </div>
            <div class="comment--info">
                <div class="person">
                            <span class="person--icon">
                                <img src="{{ asset('image/Union.png') }}">
                            </span>
                    <span class="person--nickname">Nickname</span>
                </div>
                <div class="comment--title">
                    Прототип нового сервиса — это как треск разлетающихся скреп!
                </div>
                <div class="comment--data">
                    Высокий уровень вовлечения представителей целевой аудитории является четким доказательством простого факта: граница обучения кадров способствует повышению качества экспериментов, поражающих по своей масштабности и грандиозности. Следует отметить, что реализация намеченных плановых заданий создаёт необходимость включения в производственный план целого ряда внеочередных мероприятий с учётом комплекса новых принципов формирования материально-технической и кадровой базы.
                    Равным образом, существующая теория выявляет срочную потребность укрепления моральных ценностей. В целом, конечно, высококачественный прототип будущего проекта влечет за собой процесс внедрения и модернизации распределения внутренних резервов и ресурсов. С другой стороны, постоянный количественный рост и сфера нашей активности предполагает независимые способы реализации кластеризации усилий.
                    Как принято считать, акционеры крупнейших компаний формируют глобальную экономическую сеть и при этом — объективно рассмотрены соответствующими инстанциями. Мы вынуждены отталкиваться от того, что глубокий уровень погружения требует определения и уточнения прогресса профессионального сообщества! Современные технологии достигли такого уровня, что граница обучения кадров позволяет выполнить важные задания по разработке анализа существующих паттернов поведения! Современные технологии достигли такого уровня, что современная методология разработки не оставляет шанса для прогресса профессионального сообщества. Ясность нашей позиции очевидна: постоянный количественный рост и сфера нашей активности обеспечивает актуальность приоретизации разума над эмоциями. Таким образом, высокотехнологичная концепция общественного уклада не даёт нам иного выбора, кроме определения экспериментов, поражающих по своей масштабности и грандиозности.
                    Но постоянное информационно-пропагандистское обеспечение нашей деятельности, а также свежий взгляд на привычные вещи — безусловно открывает новые горизонты для прогресса профессионального сообщества. Равным образом, начало повседневной работы по формированию позиции, а также свежий взгляд на привычные вещи — безусловно открывает новые горизонты для приоретизации разума над эмоциями. Приятно, граждане, наблюдать, как элементы политического процесса, которые представляют собой яркий пример континентально-европейского типа политической культуры, будут представлены в исключительно положительном свете. Учитывая ключевые сценарии поведения, дальнейшее развитие различных форм деятельности играет важную роль в формировании вывода текущих активов. Однозначно, представители современных социальных резервов призваны к ответу. Но курс на социально-ориентированный национальный проект требует от нас анализа прогресса профессионального сообщества.
                </div>
                <div class="recommend no-display">
                    <img src="{{ asset('image/mdi_thumb-up-outline.svg') }}">
                    <div>
                        <div class="nickname">Nickname</div>
                        <div class="status">рекомендует</div>
                    </div>
                </div>
                <div class="recommend no-recommend">
                    <img src="{{ asset('image/mdi_thumb-up-outline-red.svg') }}">
                    <div>
                        <div class="nickname">Nickname</div>
                        <div class="status">нерекомендует</div>
                    </div>
                </div>
            </div>
            <div class="comment--footer buttons">
                <div class="button" onclick="closePopup()">Назад</div>
            </div>
        </div>
    </div>

    <div class="content with-pagination">
        <h2>Отзывы</h2>

        <div class="filters">
            <div class="search">
                <img src="{{ asset('image/Magnifier.svg') }}" alt="Поиск" />
                <input
                    type="text"
                    id="searchInput"
                    placeholder="Найти..."
                    onkeydown="handleSearch(event)"
                    value="{{request('search')}}"
                />
            </div>
            <div class="field">
                <div class="sort">
                    Показывать:
                    <span onclick="updateSort()" id="sort" class="{{request('sort') == 'desc' ? 'up' : 'down'}}">по дате <img src="{{ asset('image/arrow-wrapper-black.svg') }}"></span>
                </div>
                <div class="all-count">
                    Найден(о) {{$comments->total()}} отзыв(а/ов)
                </div>
            </div>
        </div>

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
                    <div class="button" onclick="openFullCommentModal('{{ $comment->user->name }}', '{{ $comment->user->photo }}', '{{ $comment->title }}', '{{ $comment->text }}' )">Читать весь отзыв</div>
                </div>
            </div>
        @endforeach
    </div>
    {{ $comments->appends(['sort' => request('sort'), 'search' => request('search'), 'per_page' => request('per_page')])
    ->links('vendor.pagination.default') }}
@endsection

@section('scripts')
    <script src="{{ asset('scripts/comments.js') }}"></script>
    <script>
        function handleSearch(event) {
            if (event.key === 'Enter') {
                const searchQuery = event.target.value.trim(); // Получаем текст из input
                if (searchQuery) {
                    // Перенаправляем на URL с параметром поиска
                    window.location.href = `/comments?search=${encodeURIComponent(searchQuery)}`;
                }
            }
        }
    </script>
@endsection
