jQuery(function($){
    'use strict';

    $(document).on('click', '.js-tab', function(){
        var $tab = $(this).data('tab');
        var $collection = $(this).parents('.js-tab-wrapper').find('.js-tab-content');

        $(this).siblings('.js-tab').removeClass('current');
        $(this).addClass('current');

        $collection.removeClass('current');

        $collection.each(function(){
            if ($(this).data('tab') === $tab) {
                $(this).addClass('current');
            }
        });

        $.colorbox.resize();

        return false;
    });
    $(document).on('click', '.js-map', function(){
        var $this = $(this);
        var $collect = $('.js-map');

        $collect.removeClass('current');
        $this.addClass('current');

        return false;
    });
    $(document).on('click', '.js-switch-item', function(){
        var $this = $(this);
        var $collect = $this.parent('.js-switch-box');

        $collect.find('.js-switch-item').removeClass('active');
        $this.addClass('active');

        return false;
    });

    // Select init
    $('.js-select').select2();

    // Accordion
    if ($( ".b-accordion").length) {
        $(function() {
            $( ".b-accordion" ).accordion({
                heightStyle: "content"
            });
        });
    }


  /*

    // Slider
    if ( $( ".js-slider").length ) {
                console.log(JSON.stringify(listOfProducts));
                $(".js-slider").each(function (index, val, listOfProducts) {
                    var $slidesCount = $(val).data('slides');
                    var Begin_position = $(val).data('position');
                    var Preset = $(val).data('preset');
                    //listOfProducts =listOfProducts;
                    // alert ( Preset);
                    $(function () {
                        $(val).slider({
                            range: "min",
                            min: 1,
                            value: Begin_position,
                            max: $slidesCount,
                            slide: function (event, ui) {
                                // console.log( JSON.stringify( listOfProducts ));
                                //alert ( event );
                            }
                        });
                        //alert( $(val).slider( "value" ) );
                    });
                });

    }

   */

    $(document).on('change', '.js-checked-submit', function(){
        $(this).parents('.js-checked').find('label').removeClass('checked');
        $(this).parent('label').addClass('checked');
    });

    $(document).on('click', '.js-close', function(){
        $(this).parent('.js-setting').html('');
        $('.js-more-setting').removeClass('active');

        return false;
    });

    $(document).on('click', '.js-hint', function(){
        $('.js-hint-wrapper').removeClass('is-active');
        $('.js-hint-content').removeClass('is-active');

        $(this).parent('.js-hint-wrapper').addClass('is-active');
        $(this).siblings('.js-hint-content').addClass('is-active');

        return false;
    });
    $(document).on('click', '.js-hint-close', function(){
        $(this).parents('.js-hint-wrapper').removeClass('is-active');
        $(this).parent('.js-hint-content').removeClass('is-active');

        return false;
    });

    $(document).on('click', '.js-more-setting', function(){
        var $url = $(this).attr('data-url');

        $.scrollTo( '.js-setting', 1000, {onAfter:function(){
            $.ajax({
                url: $url,
                cache: false,
                success: function(html){
                    $(".js-setting").html('').append(html);
                    $('.js-select').select2();

                    // Accordion
                    if ($( ".b-accordion").length) {
                        $(function() {
                            $( ".b-accordion" ).accordion({
                                heightStyle: "content",
                                activate: function( event, ui ) {
                                    $(window).scroll();
                                }
                            });
                        });
                    }

                    $('input.hidden-input').css({'position':'absolute', 'left':'-9999px'});
                }
            });
        } });

    });

    $(document).on('click', '.js-drop-item', function(){
        valueToDrop($(this), $('.js-drop-item'));
    });

    $(document).on('click', '.js-drop-block .is-value', function(){
        return ($(this).siblings('.is-drop').is('.is-active')) ? false : $(this).addClass('is-active').siblings('.is-drop').addClass('is-active');
    });

    $('.js-modal').colorbox();


    function valueToDrop(el, collection) {
        var $item = $(el).html();

        collection.removeClass('is-active');
        el.addClass('is-active');

        el.parent('.is-drop').siblings('.is-value').removeClass('is-active').html($item);

        closeDrop(el);
    }

    function closeDrop(action) {
        action.parent('.is-drop').removeClass('is-active');
    }
});