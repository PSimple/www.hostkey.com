jQuery(function($){
    'use strict';

    $(document).on('click', '.tabs a', function () {
            $('.tabs a').removeClass('tab_sel');
            $('.html_tab').hide();
            var tabid = $(this).attr('class');
            $(this).addClass('tab_sel');
            $('.html_' + tabid).show();
            return false;
        });


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
    $(".js-select-test").select2({
        minimumResultsForSearch: Infinity
    });
    $(".vm").select2({
        minimumResultsForSearch: Infinity
    });
    $(".bwl").select2({
        minimumResultsForSearch: Infinity
    });
    $(".bal").select2({
        minimumResultsForSearch: Infinity
    });
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
        action.parent('.is-drop').removeClass('is-actid_vm_templateive');
    }



    /*
    *   Выбираем из списков опций продукта опцию по ID который динамически меняется
     */
    window.AddOptionToZakaz = function AddOptionToZakaz (  list_of_option, id_option ) {
         //window.ToStringJSON ( list_of_option );
        for( var prop_1 in list_of_option ) {
           // window.ToStringJSON ( prop_1 );
            for( var prop_2 in list_of_option[prop_1] ) {

                if(  list_of_option[prop_1][prop_2]['id'] == id_option ) {

                   return list_of_option[prop_1][prop_2] ;
                }

            }

        }

    }


    window.write_summa = function write_summa( z , curr, place ) {
        place.html( curr + " " + SumUpResultZakaz( z ) + "/" + z['payment']['data'][0].period );
    };

    window.write_dis = function write_dis( z, curr, place ) {
      //  var d = window.SumUpDiscountByMonthly( z );
        var d = window.SumUpDiscount( z );
        if ( d != 0 ){
            place.html( z['payment']['data'][0].discount + "% discount, save " + curr + " " + -d );
        } else {
            place.html('');
        }
    };

    window.ToStringJSON = function ToStringJSON ( JSONobj ) {
        console.log( JSON.stringify ( JSONobj ));
    }

    /*
     * рассчитываем стоимость заказа
     */
    window.SumUpResultZakaz = function SumUpResultZakaz( z ) {
        var period = z['payment']['data'][0].name;
        var summ = 0;
        for (var prop in z) {
            if (prop != 'payment') {

                summ = parseInt( summ  + parseFloat( z[prop]['data'][0][period] ) * 100 );
            }
        }
        return Math.floor(summ ) / 100;
    }

    /*
     *  формируем дискаунт по периоду заказа
     */
    window.SumUpDiscount = function ( z ) {
        var discount = z['payment']['data'][0].discount;
        var period = z['payment']['data'][0].name;
        var summ = 0;
        var summMonthly = 0;
        var dis=0;
        for (var prop in z) {
            if (prop != 'payment') {
                summ = parseInt( summ  + parseFloat( z[prop]['data'][0][period] ) * 100 );
                summMonthly = parseInt( summMonthly  + parseFloat( z[prop]['data'][0]['monthly'] ) * 100 );
            }
        }
        if ( parseInt( discount ) == 0){
            return 0;
        } else {
           // dis = (summ/100)* parseInt( discount );
            return Math.floor(summMonthly - summ)/100;
        }

    }


    /*
     *  формируем дискаунт по цене одного месяца
     */
    window.SumUpDiscountByMonthly = function ( z ) {

        var discount = z['payment']['data'][0].discount;
        var period = z['payment']['data'][0].name;
        var month = z['payment']['data'][0].month;
        var summ = 0;
        var dis=0;
        for (var prop in z) {
            if (prop != 'payment') {
                summ = parseInt( summ  + parseFloat( z[prop]['data'][0]['monthly'] ) * 100 );
            }
        }
        if ( parseInt( discount ) == 0){
            return 0;
        } else {
            dis = (month*summ/100)* parseInt( discount );
            return Math.floor(dis)/100;
        }

    }


    /*
     * Формируем дефолтный заказ
     */
    window.startZakaz = function startZakaz(position_products, list_of_products ) {
        var z = new Object();
        for ( var prop in list_of_products ) {
            z[prop] = new Object();
            z[prop].name = list_of_products[prop].name;
            z[prop].hidden = list_of_products[prop].hidden;
            z[prop].data = new Object();
            z[prop].data[0] = list_of_products[prop]['data'][position_products];
        }
        return z;
    }


    /*
    * На основании Zakaz создаем строку запроса
     */
    window.generate_post = function generate_post ( z ) {
        var str ='';
        for (var prop in z) {
            if (prop != 'payment') {
                if ( z[prop]['data'][0]['id'] != 'NONE' ) {
                    str =   str + "configoption[" + prop +"]=" + z[prop]['data'][0]['id'] + "&" ;/// вставляем все выбранные продукты
                }
            } else {
                str =   str + "billingcycle=" + z[prop]['data'][0]['name'] + "&" ; ///вставляем период оплаты
            }
        }
        return str;
    }

    /*
    * устанавливаем данные платежа для пресетов
     */
    window.set_payment_for_preset = function set_payment( z , l , n) {
        z.payment = new Object();
        z.payment.name = 'payment';
        z.payment.hidden = '0';
        z.payment.data = new Object();
        z.payment.data[0] = l['payment']['data'][n];
    }


    function ancorDetected (){
        var anc = window.location.hash.replace("#","");
       if( anc == 'ru' || anc == 'nl' ){
           $.scrollTo('#calc', 1000, { offset:-90 });
       }
    }

    ancorDetected ();

    });


var AJAX_SEND = function ( object_input, object_message ) {
    if ( checkout_empty_input ( object_input , object_message ) === 0 ) {
        if (zakaz != '') {
            $.ajax({
                type: 'POST',
                url: "/api/v1/configcalculator/order",
                cache: false,
                data: JSON.stringify(zakaz),
                beforeSend: function () {
                    $('#callback_btn_manage_cloud').addClass('disabled_href_button').css('color', '#fff');//блокируем кнопку отправки
                },
                success: function (msg) {
                    clear_input( object_input );// чистим поля
                    messager_windows_operator("", object_message, 'clear+hide');// чистим ошибки
                    messager_windows_operator('<a href="#" title="Success">You order Cloud VDS succefull!<br/>Go to manage you cloud.</a>', object_message, 'success');
                    // $('#callback_btn_manage_cloud').addClass('hide_href_button');//убираем кнопку опраки заказа
                    //zakaz = '';
                    // sleep( 5000);
                    /// $('.close_window_information_manager_cloud').click();
                },
                error: function (jqXHR, exception) {
                    //console.log(jqXHR);
                    // getErrorMessage(jqXHR, exception);
                },
            });
        } else {
            messager_windows_operator('', object_message, 'clear+hide');
            messager_windows_operator('Dont get Cloud VDS', object_message, 'error');
        }
    } else {

    }
    return false;
}


/*
 * возвращает количество пустых полей или полей с количеством символов не менее 5 которые не заполнены и рисует вокруг них рамку
 */
function checkout_empty_input ( e , object_message ) {
    var c = 0;
    messager_windows_operator ( "", object_message, 'clear+hide' );///Чистим и скрываем все мессанджи
    e.each(function () {
        var stroka = $(this).val().replace(/\s{2,}/g, '');
        if (stroka == '' ) {
            $(this).css('border', '2px solid red');
            messager_windows_operator ( "empty " + $(this).attr( 'placeholder' ), object_message, 'error' );
            c++;
        } else {
            if (stroka.length < 5) {
                $(this).css('border', '2px solid red');
                messager_windows_operator(stroka.length + " low count in " + $(this).attr( 'placeholder' ), object_message, 'error');
                c++;
            }
        }
    });
    return c;
}


/*
 * отображаем панельку HTML с ошибками или информацией
 * messqge - текст который выводим
 * object - куда выводим
 *
 * status  success | info | error | fatal | hide | show | clear+hide | clear | clear+success | clear+info | clear+erorr | clear+fatal
 */
function messager_windows_operator ( message, object, status ) {
    var s = object.css('display', 'block').html();
    if ( s != '') s = s + "<br/>";
    object.css('display', 'block').html( s + message );
    switch (status ){
        case 'success': object.removeClass( 'message_pole').addClass( 'write_message_success' );break;
        case 'info': object.removeClass( 'message_pole').addClass( 'write_message_info' ); break;
        case 'error': object.removeClass( 'message_pole').addClass( 'write_message_error' ); break;
        case 'fatal': object.removeClass( 'message_pole').addClass( 'write_message_fatal' ); break;
        case 'hide': object.addClass( 'message_pole' ); break;
        case 'show': object.removeClass( 'message_pole' ); break;
        case 'clear': object.html( '' ); object.removeClassWild("write_message_*"); break;
        case 'clear+hide' : object.html( '' ); object.addClass( 'message_pole' ); object.removeClassWild("write_message_*");break;
        default : alert ("sorry");
    }
}

(function($) {
    $.fn.removeClassWild = function(mask) {
        return this.removeClass(function(index, cls) {
            var re = mask.replace(/\*/g, '\\S+');
            return (cls.match(new RegExp('\\b' + re + '', 'g')) || []).join(' ');
        });
    };
})(jQuery);



/*
 *очистка полей
 */
function clear_input( object ){
    object.each( function() {
        $( this).val("");
    })
}



//////////////////////////////////////////////////////////////функции по калькулятору
/*
* получаем запрос по урлу и возвращаем JSON
 */
var AJAX_GET = function ( url, return_type ) {
    $.ajax({
        type: 'GET',
        url: url,
        cache: false,
        data: '',
        dataType: return_type.toLowerCase(),
        beforeSend: function () {
          //  $('#callback_btn_manage_cloud').addClass('disabled_href_button').css('color', '#fff');//блокируем кнопку отправки
        },
        success: function (msg) {
          // console.log( msg );
            return JSON.parse( msg );
           // clear_input( object_input );// чистим поля
           // messager_windows_operator("", object_message, 'clear+hide');// чистим ошибки
           // messager_windows_operator('<a href="#" title="Success">You order Cloud VDS succefull!<br/>Go to manage you cloud.</a>', object_message, 'success');
            // $('#callback_btn_manage_cloud').addClass('hide_href_button');//убираем кнопку опраки заказа
            //zakaz = '';
            // sleep( 5000);
            /// $('.close_window_information_manager_cloud').click();
        },
        error: function (jqXHR, exception) {
          //  console.log( exception );
            // getErrorMessage(jqXHR, exception);
        }
    });
}

