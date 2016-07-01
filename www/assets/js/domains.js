/* Приведение методов к более удобному формату */
var m,
    methods = [
        'join', 'reverse', 'sort', 'push', 'pop', 'shift', 'unshift',
        'splice', 'concat', 'slice', 'indexOf', 'lastIndexOf',
        'forEach', 'map', 'reduce', 'reduceRight', 'filter',
        'some', 'every'
    ],
    methodCount = methods.length,
    assignArrayGeneric = function (methodName) {
        if (!Array[methodName]) {
            var method = Array.prototype[methodName];
            if (typeof method === 'function') {
                Array[methodName] = function () {
                    return method.call.apply(method, arguments);
                };
            }
        }
    };

for (m = 0; m < methodCount; m++) {
    assignArrayGeneric(methods[m]);
}
/* /Приведение методов */

var i,
    a,
    contentMain = {},
    pricesSumArr = {},
    summaryPrice = 0,
    k = 0,
    searchZones = '',
    searchDomains = '',
    searchDomainsArr = '',
    isCut = false;

window.location.hash = '#domains_1';

/* Функция, отслеживающая переход по шагам */
window.addEventListener('hashchange', function () {
    switch (location.hash) {
        case '#domains_2':
            $('.domains-step2n3, #step2').css('display', 'inline-block');
            $('#step1, #step3').hide();
            break;
        /*case '#domains_3':
         if (Object.keys(pricesSumArr).length) {
         $('.domains-step2n3, #step3').css('display', 'inline-block');
         $('#step1, #step2').hide();
         }
         break;*/
        case '#domains_1':
        default:
            $('#step1').show();
            $('.domains-step2n3, #step2, #step3').hide();
            break;
    }
});

/* Функция добавления данных */
function AddData(target, data, action) {
    var $targetCont = $(target);
    if (action == 'add' || action == 'append') {
        if (action == 'add')
            $targetCont.empty();
        $targetCont.append(data);
    } else {
        $targetCont.prepend(data);
    }
    loaderView('hide');
}

/* Функция очистки от html-тегов */
String.prototype.stripTags = function () {
    return this.replace(/<\/?[^>]+>/g, '');
};

// Функция укорачивания длинных доменных имен
String.prototype.cutDomain = function () {
    var splitName = this.split('.'),
        cutName = this;
    isCut = false;
    if (splitName[0].length > 10) {
        isCut = true;
        cutName = splitName[0].substring(0, 10) + '...' + splitName[1];
    }
    return cutName;
};

/* Функция запуска попапа для трансфера
 function AddTransferPopup(container) {
 if (!$('.transferPopup').length) {
 $(container).after('<div class="transferPopup">' +
 '<span>Перенести и продлить<br/> на 1 год?</span>' +
 '<a href="#" class="transferPopup-yes">Yes</a>' +
 '<a href="#" class="transferPopup-no">No</a>' +
 '</div>');
 }
 }*/

// Show/hide loader
function loaderView(action) {
    if (action == 'hide') {
        $('.loader-view').hide();
        $('.b-domains__container').removeClass('overlay-view');
    } else {
        $('.loader-view').show();
        $('.b-domains__container').addClass('overlay-view');
    }
}

// Generate table for target domains
function genDomainsTable(target, data) {
    var readyTable = '',
        domainsList = [],
        domainsPrice = 0,
        readyTableHeader = '<thead><tr>' +
            '<th width="250" class="tab-list__content-table-cell">Domain</th>' +
            '<th width="150" class="tab-list__content-table-cell">Results</th>' +
            '<th width="220" class="tab-list__content-table-cell">Price</th>' +
            '<th width="250" class="tab-list__content-table-cell"><a href="#" data-tname="' + target + '" class="tab-list__content-reg-all"><i class="b-icon"></i>Register all<span class="tab-list__content-reg-help js-tooltip" title="Lorem ipsum..."></span></a></th>' +
            '</tr></thead><tbody>',
        readyTableFooter = '</tbody>';
    for (var key in data) {
        k++;
        if (key.substring(-1) == '.' || key == '-')
            continue;

        var name = key,
            groupDomain = data[name],
            statusClass = (groupDomain['status'] == 'available') ? 'available' : 'invalid',
            statusComment = ((groupDomain['comment'] != null && groupDomain['comment'] != undefined) ? groupDomain['comment'] : ''),
            status = groupDomain['status'],
            img = (groupDomain['img'] != null && groupDomain['img'] != undefined && groupDomain['img'] != '') ? '<img src="/upload/data/' + groupDomain['img'] + '" />' : '',
            promo = ('promo' in data[name]) ? 'promoRow' : '',
            periodOptions = '',
            cutName = name.cutDomain();

        if (groupDomain['status'] == 'available') {
            domainsList.push(name);
            domainsPrice = domainsPrice + groupDomain['PriceRegister01'];
        }
        for (var keypr in groupDomain) {
            if (keypr.slice(0, -2) == 'PriceRegister') {
                var prNum = parseInt(keypr.slice(-2)),
                    prPeriod = (prNum == 1 ? prNum + ' year' : prNum + ' years');
                periodOptions += '<option value="' + prNum + '">' + prPeriod + ' / €' + groupDomain[keypr] + '</option>';
            }
        }

        if (!(name in contentMain)) {
            contentMain[name] = groupDomain;
            contentMain[name]['cutName'] = cutName;
        }

        readyTable += '<tr class="tab-list__content-table-row rowN' + k + ' tab-list__content-table-row__' + statusClass + ((name in pricesSumArr) ? ' selected_row' : '') + '">' +
            '<td class="tab-list__content-table-cell' + (!isCut ? '' : ' js-tooltip" title="' + name) + '">' +
            '<span class="tab-list__content-table-cell-img">' + img + '</span>' + (!isCut ? name : cutName) + '' +
            '</td>' +
            '<td class="tab-list__content-table-cell">' +
            status + (statusComment == '' ? '' : '<span class="status-content-tt js-tooltip" title="' + statusComment + '"></span>') +
            '</td>' +
            '<td class="tab-list__content-table-cell">' +
            ((statusClass == "available") ? '<select class="table-select__item js-select" name="tbl-select-' + k + '" id="regPeriod' + k + '" data_preset="Register_Domains">' + periodOptions + '</select>' : '') +
            '</td>' +
            '<td class="tab-list__content-table-cell buttonCell">' +
            '<a href="#" class="tab-list__content-reg-this" data-domain="' + name + '" data-rowN="' + k + '"><i class="b-icon"></i>Register</a>' +
            '</td>' +
            '</tr>';
    }

    if (readyTable == '') {
        readyTable = '<tr><td colspan="4" align="center">Wrong request. Try again.</td></tr>';
        $(target).addClass('emptyResp');
    } else if ($(target).is(':empty')) {
        readyTable = readyTableHeader + readyTable + readyTableFooter;
    }

    if (!$(target).hasClass('emptyResp')) {
        AddData(target, readyTable, 'prepend');
        $(target).addClass('notEmpty');
    }
    // else {
    //     AddData(target, readyTable, 'add');
    // }
    var qDom = domainsList.length,
        numVariation = ' доменов';

    switch (qDom) {
        case 1:
            numVariation = ' домен';
            break;
        case 2:
        case 3:
        case 4:
            numVariation = ' домена';
            break;
        default:
            numVariation = ' доменов';
            break;

    }

    $(target).after('<div class="regAllContainer"><div class="regAllContent">' +
        '<div class="regAllTitle">Зарегистрировать на 1 год ' + qDom + numVariation + ' за €' + domainsPrice.toFixed(2) + ':</div>' +
        domainsList.join(', ') + '</div>' +
        '<a href="#" data-tname="' + target + '" class="regAllButton"><i class="b-icon"></i>Register all</a>' +
        '</div>');

    $('.js-select').select2();
}

$(document).on('click', 'a.tab-list__content-reg-this', function () {
    var $domain = $(this).attr('data-domain'),
        cutName = $domain.cutDomain(),
        $rowN = $(this).attr('data-rown'),
        $row = $('.rowN' + $rowN),
        $priceNper = $('#regPeriod' + $rowN + ' option:selected').html(),
        $priceSplit = ($('#regPeriod' + $rowN + ' option:selected').html()).split('€'),
        $price = $priceSplit[1],
        $section = $('#registerSection');

    if ($domain in contentMain) {
        if (!($domain in pricesSumArr)) {
            $row.addClass('selected_row');
            pricesSumArr[$domain] = contentMain[$domain];
            pricesSumArr[$domain]['action'] = 'reg';
            pricesSumArr[$domain]['period'] = $priceNper;

            if (!$section.is(':visible'))
                $section.addClass('visible_section');

            $('#domains-register-table').find('tbody').append(
                '<tr class="domains-step__summary-table-row">' +
                '<td class="domains-step__summary-table-cell domain-title-show' + (!isCut ? '' : ' js-tooltip" title="' + $domain) + '">' +
                (!isCut ? $domain : cutName) + '</td>' +
                '<td class="domains-step__summary-table-cell remove-row" data-rowN="' + $rowN + '" data-domain="' + $domain + '">€' + $price + '</td>' +
                '</tr>');
            summaryPrice = parseFloat(summaryPrice) + parseFloat($price);
            $('#Summa').html('€' + summaryPrice.toFixed(2));
        }
    }
    return false;
});

// Начальная загрузка области под поиском
$.getJSON('/api/v1/shop/domains/zone/list?groups=top100', function (data) {
    var items = data['Content'],
        ready = '',
        sum = items.length;

    if (sum > 6) {
        sum = 6;
        $('#domain-zone__more').css("display", "block");
    }

    for (i = 0; i < sum; i++) {
        var name = items[i].Name,
            price = items[i].PriceRegister;

        ready += '<label class="domain-zone__item" for="regular_check-' + i + '">' +
            '<span class="domain-zone__item-title">' + name + '</span><br>' +
            '<input data-name="' + name + '" class="hidden-input" name="check-' + i + '" type="checkbox" id="regular_check-' + i + '"/>' +
            '<span class="domain-zone__item-price">€' + price + '</span>' +
            '</label>';
    }
    AddData('.domain-zone', ready, 'add');
});

/* Начальная загрузка области Special offers */
$.getJSON('/api/v1/shop/domains/zone/list?groups=promo', function (data) {
    var items = data['Content'],
        readyPromo = '',
        sum = items.length;

    if (sum > 4) {
        sum = 4;
        $('#domains-check__more').css("display", "block");
    }
    for (a = 0; a < sum; a++) {
        var name = items[a].Name,
            img = '<img src="/upload/data/' + items[a].Img + '" title="' + name + '"/>',
            imgFlag = items[a].Img,
            price = items[a].PriceRegister,
            comment = (!!items[a].Comment) ? ((items[a].Comment).stripTags()) : '',
            slicedComment = comment.slice(0, 90);

        if (slicedComment.length < comment.length) {
            slicedComment += '...';
            comment = slicedComment;
        }

        var priceold = items[a].PriceOld;
        readyPromo += '<label class="fake-checkbox-label domains-check__item">' +
            '<h3 class="domains-check__item-title">' + (imgFlag != null ? img : name) + '</h3>' +
            '<div class="domains-check__item-text">' + comment + '</div>' +
            '<div class="domains-check__item-price">' +
            '<div class="domains-check__item-price-new"> €' + price + '</div>' +
            '<div class="domains-check__item-price-old"> €' + priceold + '</div>' +
            '</div>' +
            '<span class="fake-checkbox-label__box js-check"></span><input data-name="' + name + '" class="hidden-input" name="check-1" type="checkbox"/>' +
            '<div class="domains-check__item-register">register</div><div class="domains-check__item-order">order</div>' +
            '</label>';

    }
    AddData('.domains-check__row', readyPromo, 'add');
});

/* Вывод полного списка доменных зон в область под поиском */
$('#domain-zone__more').on('click', '', function () {
    $.getJSON('/api/v1/shop/domains/zone/list?groups=top100', function (data) {
        var items = data['Content'];
        var ready = '';
        var iter = items.length;
        for (i; i < iter; i++) {
            var name = items[i].Name;
            var price = items[i].PriceRegister;
            ready += '<label class="domain-zone__item" for="regular_check-' + i + '">' +
                '<span class="domain-zone__item-title">' + name + '</span><br>' +
                '<input data-name="' + name + '" class="hidden-input" name="check-' + i + '" type="checkbox" id="regular_check-' + i + '"/>' +
                '<span class="domain-zone__item-price">€' + price + '</span>' +
                '</label>';
        }
        AddData('.domain-zone', ready, 'append');
    });
    $(this).hide();
    return false;
});

/* Вывод полного списка доменных зон в Special Offers */
$('#domains-check__more').on('click', '', function () {
    $.getJSON('/api/v1/shop/domains/zone/list?groups=promo', function (data) {
        var items = data['Content'];
        var readyPromo = '';
        var iter = items.length;
        for (a; a < iter; a++) {
            var name = items[a].Name;
            var img = '<img src="/upload/data/' + items[a].Img + '" title="' + name + '"/>';
            var imgFlag = items[a].Img;
            var price = items[a].PriceRegister;
            var comment = (!!items[a].Comment) ? ((items[a].Comment).stripTags()) : '';
            var slicedComment = comment.slice(0, 90);
            if (slicedComment.length < comment.length) {
                slicedComment += '...';
                comment = slicedComment;
            }
            var priceold = items[a].PriceOld;
            readyPromo += '<label class="fake-checkbox-label domains-check__item">' +
                '<h3 class="domains-check__item-title">' + (imgFlag != null ? img : name) + '</h3>' +
                '<div class="domains-check__item-text">' + comment + '</div>' +
                '<div class="domains-check__item-price">' +
                '<div class="domains-check__item-price-new"> €' + price + '</div>' +
                '<div class="domains-check__item-price-old"> €' + priceold + '</div>' +
                '</div>' +
                '<span class="fake-checkbox-label__box js-check"></span><input data-name="' + name + '" class="hidden-input" name="check-1" type="checkbox"/>' +
                '<div class="domains-check__item-register">register</div><div class="domains-check__item-order">order</div>' +
                '</label>';

        }
        AddData('.domains-check__row', readyPromo, 'append');
    });
    $(this).hide();
    return false;
});

/* Чистка области поиска от лишних символов на лету */
$('.search-bar__input').on('keyup', function (e) {
    var svalue = $(this).val().replace(/[^a-zA-Zа-яА-Я0-9-^.\n]/g, '');
    var nvalue = $(this).val().replace(/[,;!@#$%^&*()_=+<>/\\'"\[\]\{\}№:? ]/g, '\n');
    $(this).val(svalue);
    $(this).val(nvalue);

    if ($('.search-bar__input:visible').val() == '') {
        $('.search-bar .b-submit').addClass('search-bar__submit__disabled');
    } else {
        $('.search-bar .b-submit').removeClass('search-bar__submit__disabled');
    }

    if (e.keyCode == 13 && $('input.search-bar__input').is(':visible') && !$('.search-bar .b-submit').hasClass('search-bar__submit__disabled')) {
        $('.search-bar .b-submit').click();
    }

});

/* Переключение поисковой области в многострочный режим */
$('.search-bar__button-bulk').on('click', '', function () {
    $('.search-bar__input').toggleClass('search-bar__input-hidden');
    $('.search-bar__input:visible').val($('.search-bar__input').not(':visible').val());
    $(this).hide();
});

/* Запуск поиска и переход на второй шаг */
$('.search-bar .b-submit').on('click', '', function () {
    var $checkedInput = $('.hidden-input:checked'),
        $firstTab = $('.domains-step2__tab .tab-list__item[data-tab="1"]');

    loaderView('show');

    $('.tab-list__content-table').removeClass('notEmpty');

    if (!$firstTab.hasClass('current'))
        $firstTab.trigger('click');

    searchZones = '';
    $.each($checkedInput, function () {
        searchZones += $(this).data('name').replace('.', '') + ',';
    });
    searchZones = searchZones.slice(0, -1);

    searchDomains = ($('.search-bar__input:visible').val()).replace(/\n/g, ',');
    if (searchDomains.substr(-1, 1) == ',') {
        searchDomains = searchDomains.substr(0, -1);
    }
    searchDomainsArr = searchDomains.split(',');

    // Возвращаем строчный вид поиска на 2 шаге
    if (!$('input.search-bar__input').is(':visible')) {
        $('.search-bar__button-bulk').trigger('click');
    }

    // Чистим поля поиска
    $('input.search-bar__input, textarea.search-bar__input').val('');

    for (var key in searchDomainsArr) {
        var onedomainname = searchDomainsArr[key],
            group1domains = {},
            group2domains = {};

        $.getJSON('/api/v1/shop/domains/check?domainList=' + onedomainname + '&zoneList=' + searchZones, function (data) {

            group1domains = data['Content']['group1'];
            group2domains = data['Content']['group2'];

            genDomainsTable('#result-table', group1domains);
            genDomainsTable('#result-table2', group2domains);


            /* Бинд библиотеки tooltip для всплывающих подсказок */
            $('.js-tooltip').tooltip();
        });

    }
    window.location.hash = '#domains_2';

    $('html, body').animate({
        scrollTop: $("#step2").offset().top
    }, 2000);

    return false;
});

/* Обработка кнопки "Register All" в шапке таблиц */
$(document).on('click', '.tab-list__content-reg-all, .regAllButton', function () {
    var $table = $($(this).attr('data-tname')),
        $row = $table.find('.tab-list__content-table-row__available'),
        $select = $table.find('.table-select__item');
    $.each($row, function () {
        $(this).find('.table-select__item').val("1").trigger("change");
        $(this).find('.tab-list__content-reg-this:visible').trigger('click');
    });
    return false;
});

/* Обработка переключения табов и подгрузки контента на втором шаге */
$('.tab-list__item').on('click', '', function () {
    var popularTable = '',
        thisid = $(this).attr('data-id'),
        target = '#' + thisid + 'Table';
    if (!$(target).hasClass('notEmpty') && $(this).attr('data-tab') != 1) {

        loaderView('show');
        $.getJSON('/api/v1/shop/domains/check/groups?domainList=' + searchDomains + '&group=' + thisid + '&pg=1', function (data) {
            var activeTabContent = data['Content'];
            genDomainsTable(target, activeTabContent);
            $(target).addClass('notEmpty');

            // AddData(target, popularTable, 'add');
            // bindTableClick();


        });
    }
});

// Переход на третий шаг
$('#buy').on('click', '', function () {
    var summaryData = {},
        domains = Object.keys(pricesSumArr).join(', ');
    if (Object.keys(pricesSumArr).length) {
        summaryData = '';
        for (var key in pricesSumArr) {
            if (pricesSumArr[key]['action'] == 'reg' && pricesSumArr[key]['status'] == 'available') {

                summaryData += 'domains[]:' + key + ', domainsregperiod[' + key + ']: 1';
            }
        }
        $.redirect('https://bill.hostkey.com/cart.php?a=add&domain=register', summaryData);
    }
});

/* Обработка совершения покупки на втором шаге, формирование третьего шага (old)
 $('#buy').on('click', '', function () {
 var summaryRegData = '',
 summaryTransData = '',
 reg_disabled = '',
 k = 0;

 for (var key in pricesSumArr) {
 var pricesArr = pricesSumArr[key];
 if (pricesSumArr[key]['action'] == 'reg') {
 var periodOptions = '';
 if (pricesSumArr[key]['idprotection'] == 0) {
 reg_disabled = 'disabled="disabled"';
 } else {
 reg_disabled = '';
 }
 for (var keyp in pricesArr) {
 var prNum = keyp.slice(-2),
 prPeriod = '';
 if (keyp.slice(0, -2) == 'PriceRegister') {
 switch (prNum) {
 case '01':
 default:
 prPeriod = prNum + ' year';
 break;
 case '02':
 case '03':
 case '04':
 case '05':
 case '06':
 case '07':
 case '08':
 case '09':
 case '10':
 prPeriod = prNum + ' years';
 break;
 }
 periodOptions += '<option value="' + prNum + '">' + prPeriod + ' / €' + pricesArr[keyp] + '</option>';
 }
 }
 summaryRegData += '<tr class="tab-list__content-table-row">' +
 '<td class="tab-list__content-table-cell" title="' + key + '">' + key.cutDomain() + '</td>' +
 '<td class="tab-list__content-table-cell"><select class="table-select__item js-select" name="tbl-select-' + k + '" id="domains-register-period-select' + k + '" data_preset="' + k + '">' + periodOptions + '</select></td>' +
 '<td class="tab-list__content-table-cell"><input type="checkbox" class="js-switch"></td>' +
 '<td class="tab-list__content-table-cell"><input type="checkbox" class="js-switch" ' + reg_disabled + '></td>' +
 '</tr>';

 } else if (pricesSumArr[key]['action'] == 'trans') {

 if (pricesSumArr[key]['idprotection'] == 0) {
 reg_disabled = 'disabled="disabled"';
 } else {
 reg_disabled = '';
 }
 summaryTransData += '<tr class="tab-list__content-table-row">' +
 '<td class="tab-list__content-table-cell" title="' + key + '">' + key.cutDomain() + '</td>' +
 '<td class="tab-list__content-table-cell"><input type="text" id="transferTablePass-' + k + '"></td>' +
 '<td class="tab-list__content-table-cell"><input type="checkbox" class="js-switch"></td>' +
 '<td class="tab-list__content-table-cell"><input type="checkbox" class="js-switch" ' + reg_disabled + '></td>' +
 '</tr>';

 }
 k++;
 $('.js-select').select2();
 }
 AddData('#summaryRegTable', summaryRegData);
 AddData('#summaryTransTable', summaryTransData);
 window.location.hash = '#domains_3';

 // Бинд библиотеки Switchery для переключателей на третьем шаге
 var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch')),
 switchery = {};
 elems.forEach(function (html) {
 if ($(this).attr('disabled') != 'disabled')
 switchery = new Switchery(html, {color: '#945ae0'});
 else
 switchery = new Switchery(html, {color: '#945ae0', disabled: true});
 });

 return false;
 });
 */

/* Удаление выбранного домена из корзины на 2 шаге */
$(document).on('click', '.domains-step__summary-table .remove-row', function () {
    var $rowCart = $(this).parents('.domains-step__summary-table-row'),
        $domain = $(this).attr('data-domain'),
        $section = $(this).parents('.domains-step__summary-section'),
        $price = parseFloat($(this).html().slice(1)),
        $rowN = $(this).attr('data-rown');

    delete pricesSumArr[$domain];
    $rowCart.remove();
    $('.rowN' + $rowN).removeClass('selected_row');
    if ($section.find('td').length == 0)
        $section.removeClass('visible_section');
    summaryPrice = parseFloat(summaryPrice) - parseFloat($price);
    $('#Summa').html('€' + summaryPrice.toFixed(2));
    if (summaryPrice == 0)
        $('#Summa').html('Empty Cart');
});