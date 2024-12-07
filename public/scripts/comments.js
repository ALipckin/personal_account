function updateComment() {
    console.log('здесь нужно получить полную информацию с бэка и впихнуть в попап. Удачи');
    openPopup();
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

