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

    //checkbox
    if ($('.domain-zone__item input').length) {

        $('.domain-zone__item input').each(function() {
            $(this).parent('.domain-zone__item').removeClass('is-check');
        });

        $('.domain-zone__item input:checked').each(function() {
            $(this).parent('label').addClass('is-check');
        });
    }

}

$('input.hidden-input').css({'position':'absolute', 'left':'-9999px'});

$(document).on('click', '.fake-checkbox-label, .fake-radio-label, .domain-zone__item', function() {
    setupLabel();
});

setupLabel();