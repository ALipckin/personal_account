<script>
    /** закрывать при клике вне */
    function openPersonPopup() {
        let popupClasses = $("#person-popup").attr('class');
        if (popupClasses.indexOf('no-display') >= 0) {
            $("#person-popup").removeClass('no-display');
        } else {
            $("#person-popup").addClass('no-display');
        }
    }

    jQuery(function($){
        $(document).mouseup( function(e) {
            var div = $("#person-popup");
            if ( !div.is(e.target) && div.has(e.target).length === 0 ) {
                $("#person-popup").addClass('no-display');
            }
        });
    });

    function openPage(page) {
        window.location = './' + page + '.html';
    }

    function openPopup() {
        $('#add-comment').removeClass('no-display');
    }

    function closePopup() {
        $('#add-comment').addClass('no-display');
        $('#popup-comment').addClass('no-display');
    }

    function isAuthorized () {
        let authorized = {{ Auth::check() ? 'true' : 'false' }};
        if (authorized) {
            $('[authorized]').removeClass('no-display');
            $('[not-authorized]').addClass('no-display');
        } else {
            $('[authorized]').addClass('no-display');
            $('[not-authorized]').removeClass('no-display');
        }
    }

    function showPassword(element) {
        let show = $(element).attr('class');
        const target = $(element).closest('div').find('.password');  // Находим целевой элемент через класс

        if (show.indexOf('private-off') >= 0) {
            $(element).removeClass('private-off');
            // Скрыть пароль
            target.attr('type', 'password');
        } else {
            $(element).addClass('private-off');
            // Показать пароль
            target.attr('type', 'text');
        }
    }

    window.onload = function() {
        setTimeout(function() {
            isAuthorized()
        }, 10);
    };

    function removeError(field){
        const passwordField = document.querySelector(field);
        const errorMessage = passwordField.querySelector('.error-message');
        errorMessage.textContent = "";
        passwordField.classList.remove('border-red');
    }

    function setError(field, text){
        const passwordField = document.querySelector(field);
        const errorMessage = passwordField.querySelector('.error-message');
        // Добавляем класс для отображения ошибки
        passwordField.classList.add('border-red');  // Добавляем красную рамку, например, для выделения ошибки

        if (errorMessage) {
            // Вставляем текст ошибки в div с классом error-message
            errorMessage.textContent = text;  // Текст ошибки
        }
    }
</script>
