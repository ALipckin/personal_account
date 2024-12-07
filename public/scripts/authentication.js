window.onload = function () {
    setTimeout(function() {
        isAuthorized();
    }, 10);

    // Обработчики кликов
    $('#auth').on('click', function () {
        authShow.call(this); // Передаём текущий контекст
    });

    $('#registration').on('click', function () {
        registrationShow.call(this); // Передаём текущий контекст
    });

    // Функция, которая выполняется при наличии параметра registration=1
    function registrationShow() {
        // Обновляем состояние DOM
        $('#auth').removeClass('active');
        $('#auth-data').addClass('no-display');
        $(this).addClass('active'); // Работает корректно, так как `this` передан
        $('#registration-data').removeClass('no-display');

        // Добавляем параметр registration=1 в URL
        const url = new URL(window.location.href);
        url.searchParams.set('registration', '1'); // Устанавливаем/обновляем параметр
        window.history.pushState(null, '', url.toString()); // Обновляем адресную строку без перезагрузки
    }

    function authShow() {
        // Обновляем состояние DOM
        $('#registration').removeClass('active');
        $('#registration-data').addClass('no-display');
        $(this).addClass('active'); // Работает корректно, так как `this` передан
        $('#auth-data').removeClass('no-display');

        // Убираем параметр registration из URL
        const url = new URL(window.location.href);
        url.searchParams.delete('registration'); // Удаляем параметр
        window.history.pushState(null, '', url.toString()); // Обновляем адресную строку без перезагрузки
    }

    // Функция для проверки параметра URL
    function checkRegistrationParameter() {
        // Получаем параметры URL
        const urlParams = new URLSearchParams(window.location.search);
        const registration = urlParams.get('registration');

        // Если параметр равен 1, вызываем функцию
        if (registration === '1') {
            registrationShow.call($('#registration')[0]); // Передаём кнопку регистрации
        }
    }

    // Обработчик на кнопку регистрации
    document.getElementById('register-button').addEventListener('click', function(event) {
        const consentCheckbox = document.getElementById('consent');
        const errorMessage = document.getElementById('error-message');

        if (!consentCheckbox.checked) {
            event.preventDefault(); // Останавливаем стандартное поведение кнопки
            errorMessage.style.display = 'block'; // Показываем сообщение об ошибке
        } else {
            errorMessage.style.display = 'none'; // Скрываем сообщение об ошибке
            // Здесь можно добавить логику отправки формы
        }
    });

    // Проверяем параметр registration при загрузке страницы
    checkRegistrationParameter();
};
