function setupLabel() {
    //checkbox
    if ($('.fake-checkbox-label input').length) {

        $('.fake-checkbox-label .js-check').each(function() {
            $(this).removeClass('checked');
            $(this).parent('.fake-checkbox-label').removeClass('is-check');
        });

        $('.fake-checkbox-label input:checked').each(function() {
            $(this).siblings('.js-check').addClass('checked');
            $(this).parent('label').addClass('is-check');
        });
    }

    //radio buttons
    if ($('.fake-radio-label input').length) {

        $('.fake-radio-label .js-check').each(function() {
            $(this).removeClass('checked');
        });

        $('.fake-radio-label input:checked').each(function() {
            $(this).siblings('.js-check').addClass('checked');
        });
    }
}

$('input.hidden-input').css({'position':'absolute', 'left':'-9999px'});

$(document).on('click', '.fake-checkbox-label, .fake-radio-label', function() {
    setupLabel();
});

setupLabel();