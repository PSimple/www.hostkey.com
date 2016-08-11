if ($('.js-carousel').length) {
    $('.js-carousel').slick({
        dots: true,
        centerMode: false,
        arrows: true,
        slidesToShow: 3,
        slidesToScroll: 3,
        centerPadding: '40px'
    });
}

if ($('.js-carousel-4').length) {
    $('.js-carousel-4').slick({
        dots: false,
        centerMode: false,
        arrows: true,
        slidesToShow: 4,
        slidesToScroll: 4,
        centerPadding: '40px'
    });
}
