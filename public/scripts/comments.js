function updateComment(id = null, title = '', text = '', recommend = null) {
    pushDataToCommentModal(id, title, text, recommend);
    openPopup('Редактировать отзыв', 'Сохранить');
}
function pushDataToCommentModal(id = null, title = '', text = '', recommend = null) {
    $('#comment-id').val(id ? id : '');
    $('#title-field input').val(title);
    $('#text-field textarea').val(text);

    if (recommend == 1) {
        $('#recommend-yes').prop('checked', true);
    } else if (recommend === 0) {
        $('#recommend-no').prop('checked', true);
    } else {
        $('#recommend-yes').prop('checked', false);
        $('#recommend-no').prop('checked', false);
    }
}

async function submitComment() {
    const titleFieldId = '#title-field';
    const textFieldId = '#text-field';
    const recommendFieldId = '#recommend-field';
    const commentIdFieldId = '#comment-id';

    const titleFieldVal = $(`${titleFieldId} input`).val();
    const textFieldVal = $(`${textFieldId} textarea`).val();
    const recommendFieldVal = $(`${recommendFieldId} input[name="recommend"]:checked`).val();
    const commentIdFieldVal = $(`${commentIdFieldId}`).val();

    // Убираем старые ошибки
    removeError(titleFieldId);
    removeError(textFieldId);
    removeError(recommendFieldId);

    // Проверка, чтобы все обязательные поля были заполнены
    if (!titleFieldVal || !textFieldVal) {
        alert('Пожалуйста, заполните все обязательные поля');
        return;
    }

    // Отправка данных
    await saveCommentData(titleFieldVal, textFieldVal, recommendFieldVal, commentIdFieldVal);
}

// Привязка обработчика через addEventListener
document.getElementById('submitComment').addEventListener('click', submitComment);
async function saveCommentData(title, text, recommend, id = null) {
    console.log("id = ", id);
    const url = id ? `/comment/${id}` : '/comment'; // Определяем URL
    const method = id ? 'PATCH' : 'POST'; // Определяем HTTP-метод

    try {
        const response = await fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            body: JSON.stringify({
                title: title,
                text: text,
                recommended: recommend,
            })
        });

        const data = await response.json();

        if (data.status_code === 422) { // Ошибка валидации
            handleValidationErrors(data.message);
        } else {
            closePopup(); // Закрываем модальное окно после успешного сохранения
            location.reload();
        }
    } catch (error) {
        alert('Произошла ошибка: ' + (error.message || 'Неизвестная ошибка'));
    }
}

function handleValidationErrors(errors) {
    if (errors.title) {
        setError('titleFieldId', errors.title[0]); // Устанавливаем первую ошибку для title
    }
    if (errors.text) {
        setError('textFieldId', errors.text[0]); // Устанавливаем первую ошибку для text
    }
    if (errors.recommended) {
        setError('recommendFieldId', errors.recommended[0]); // Устанавливаем первую ошибку для recommend
    }
}
function showAll() {
    $('#popup-comment').removeClass('no-display');
}
function updateSort() {
    // Получаем текущий класс кнопки сортировки
    let sort = $('#sort').hasClass('up') ? 'asc' : 'desc';  // Если класс 'up', то сортируем по возрастанию

    // Меняем класс на кнопке для отображения текущего состояния
    if (sort === 'asc') {
        $('#sort').removeClass('up').addClass('down');  // Если сортировка по возрастанию, меняем на убывание
    } else {
        $('#sort').removeClass('down').addClass('up');  // Если сортировка по убыванию, меняем на возрастание
    }

    // Получаем текущий URL и добавляем или обновляем параметр sort
    let url = new URL(window.location.href);
    url.searchParams.set('sort', sort);  // Устанавливаем параметр сортировки

    // Получаем значения параметров поиска и количества элементов на странице
    let search = $('#search').val();
    if (search) {
        url.searchParams.set('search', search);  // Если есть поиск, добавляем в URL
    }

    let perPage = $('#perPage').val();
    if (perPage) {
        url.searchParams.set('per_page', perPage);  // Если задано количество на странице, добавляем
    }

    // Перезагружаем страницу с новым URL, чтобы обновить данные
    window.location.href = url.toString();  // Перенаправляем на новый URL
}



