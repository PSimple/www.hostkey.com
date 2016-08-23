

var scrollBox = $('#scroll-box');
var scrollBlock = $('#scroll-block');
var $topPositionBox = 0;
var $heightScrollBox = 0;
var $heightScrollBlock = 0;
var $topPositionDocument = 0;


if (scrollBox.length) {
    $(window).on('scroll', function(){
        countAllPosition();

        if ($heightScrollBox < $heightScrollBlock) {
            scrollBlock.removeClass('is-fixed').removeClass('is-bottom');
            return;
        }


        if ($topPositionDocument >= $topPositionBox - 100) {
            scrollBlock.addClass('is-fixed');
        } else {
            scrollBlock.removeClass('is-fixed');
        }

        if ($topPositionDocument > ($topPositionBox + $heightScrollBox - $heightScrollBlock - 120)) {
            scrollBlock.addClass('is-bottom');
        } else {
            scrollBlock.removeClass('is-bottom');
        }
    });
    countAllPosition();
}

function countAllPosition() {
    $topPositionDocument = $(document).scrollTop();
    $topPositionBox = scrollBox.offset().top;
    $heightScrollBox = scrollBox.height();
    $heightScrollBlock = scrollBlock.height();
}
