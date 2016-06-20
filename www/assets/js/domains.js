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

var i, a;
var reg = [],
    reg_prot = [],
    trans_prot = [],
    trans = [],
    group1main = {},
    group2main = {},
    contentMain = {},
    domName = [],
    pricesSumArr = {};
var summaryPrice = 0,
    searchZones = '',
    searchDomains = '',
    searchDomainsArr = '';

window.location.hash = '#domains_1';

/* Функция, отслеживающая переход по шагам */
window.addEventListener('hashchange', function () {
    switch (location.hash) {
        case '#domains_2':
            $('.domains-step2n3, #step2').css('display', 'inline-block');
            $('#step1, #step3').hide();
            break;
        case '#domains_3':
            if (reg.length || trans.length) {
                $('.domains-step2n3, #step3').css('display', 'inline-block');
                $('#step1, #step2').hide();
            }
            break;
        case '#domains_1':
        default:
            $('#step1').show();
            $('.domains-step2n3, #step2, #step3').hide();
            break;
    }
});

/* Функция добавления данных поверх уже существующих */
function AddData(target, data) {
    $(target).html(data);
}

/* Функция добавления данных после уже существующих */
function AppendData(target, data) {
    $(target).append(data);
}

/* Функция добавления данных перед уже существующими */
function PrependData(target, data) {
    $(target).prepend(data);
}

/* Функция очистки от html-тегов */
String.prototype.stripTags = function () {
    return this.replace(/<\/?[^>]+>/g, '');
};

/* Функция укорачивания длинных доменных имен */
String.prototype.cutDomain = function () {
    var splitName = this.split('.');
    var cutName = this;
    if (splitName[0].length > 10)
        cutName = splitName[0].substring(0, 10) + '...' + splitName[1];
    return cutName;
};

/* Функция запуска попапа для трансфера */
function AddTransferPopup(container) {
    if (!$('.transferPopup').length) {
        $(container).after('<div class="transferPopup">' +
            '<span>Перенести и продлить<br/> на 1 год?</span>' +
            '<a href="#" class="transferPopup-yes">Yes</a>' +
            '<a href="#" class="transferPopup-no">No</a>' +
            '</div>');
    }
}

// Show/hide loader
function loaderView() {
    $('.b-domains__container').toggleClass('loader-view');
}

/* Функция очистки от html-тегов */
function bindTableClick() {
    $('.tab-list__content-table-row__available').on('click', 'a.tab-list__content-reg-this', function () {
        var domain = $(this).attr('data-domain'),
            prot = $(this).attr('data-prot'),
            price = $(this).attr('data-price'),
            searchThis = reg.indexOf(domain);

        if (domain in contentMain)
            if (!(domain in pricesSumArr))
                pricesSumArr[domain] = contentMain[domain];
        if (searchThis !== undefined && searchThis != null) {
            if (searchThis < 0) {
                if (!$('#registerSection').is(':visible'))
                    $('#registerSection').addClass('visible_section');
                reg.push(domain);
                reg_prot.push(prot);
                $('#domains-register-table tbody').append(
                    '<tr class="domains-step__summary-table-row">' +
                    '<td class="domains-step__summary-table-cell domain-title-show" title="' + domain + '">' + domain.cutDomain() + '</td>' +
                    '<td class="domains-step__summary-table-cell">€' + price + '</td>' +
                    '</tr>');
                summaryPrice = parseFloat(summaryPrice) + parseFloat(price);
                $('#Summa').html('€' + summaryPrice.toFixed(2));

            }
        }
        return false;
    });
    $('.tab-list__content-table-row__registred').on('click', 'a.tab-list__content-its-my', function (e) {
        var domain = $(this).attr('data-domain'),
            prot = $(this).attr('data-prot'),
            priceTrans = $(this).attr('data-pricetrans'),
            searchThis = reg.indexOf(domain);

        if (searchThis !== undefined && searchThis != null) {
            if (searchThis < 0) {
                AddTransferPopup(this);
                var div = $('.transferPopup');
                div.on('click', 'a', function () {
                    if (!$(this).hasClass('transferPopup-no')) {
                        if (!$('#transferSection').is(':visible'))
                            $('#transferSection').addClass('visible_section');
                        trans.push(domain);
                        trans_prot.push(prot);
                        $('#domains-transfer-table tbody').append(
                            '<tr class="domains-step__summary-table-row">' +
                            '<td class="domains-step__summary-table-cell domain-title-show" title="' + domain + '">' + domain.cutDomain() + '</td>' +
                            '<td class="domains-step__summary-table-cell">€' + priceTrans + '</td>' +
                            '</tr>');
                        summaryPrice = parseFloat(summaryPrice) + parseFloat(priceTrans);
                        $('#Summa').html('€' + summaryPrice.toFixed(2));
                    }
                    div.remove();
                    return false;
                });

            }
        }
        return false;
    });

    /* Бинд библиотеки tooltip для всплывающих подсказок */
    $('.tab-list__content-reg-help:after, .tab-list__content-table-cell, .domain-title-show, .tab-list__content-table-row__available .status-content-tt').tooltip();
    loaderView();
}

/* Хайд попапа при клике вне его области */
$(document).mouseup(function (e) {
    var div = $(".transferPopup");
    if (!div.is(e.target)
        && div.has(e.target).length === 0) {
        div.remove();
    }
});

/* Начальная загрузка области под поиском */
$.getJSON('/api/v1/shop/domains/zone/list?groups=top100', function (data) {
    var items = data['Content'];
    var ready = '';
    var sum = items.length;
    if (sum > 6) {
        sum = 6;
        $('#domain-zone__more').css("display", "block");
    }
    for (i = 0; i < sum; i++) {
        var name = items[i].Name;
        var price = items[i].PriceRegister;
        ready += '<label class="domain-zone__item" for="regular_check-' + i + '">' +
            '<span class="domain-zone__item-title">' + name + '</span><br>' +
            '<input data-name="' + name + '" class="hidden-input" name="check-' + i + '" type="checkbox" id="regular_check-' + i + '"/>' +
            '<span class="domain-zone__item-price">€' + price + '</span>' +
            '</label>';
    }
    AddData('.domain-zone', ready);
});

/* Начальная загрузка области Special offers */
$.getJSON('/api/v1/shop/domains/zone/list?groups=promo', function (data) {
    var items = data['Content'];
    var readyPromo = '';
    var sum = items.length;

    if (sum > 4) {
        sum = 4;
        $('#domains-check__more').css("display", "block");
    }
    for (a = 0; a < sum; a++) {
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
    AddData('.domains-check__row', readyPromo);
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
        AppendData('.domain-zone', ready);
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
        AppendData('.domains-check__row', readyPromo);
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
    var $checkedInput = $('.hidden-input:checked');

    var readyTable = '',
        readyTable2 = '';

    $('.b-domains__container').addClass('loader-view');

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

    // Возвращаем инпут и чистим его
    if (!$('input.search-bar__input').is(':visible')) {
        $('.search-bar__button-bulk').click();
        $('input.search-bar__input').val('');
    }
    for (var key in searchDomainsArr) {
        var onedomainname = searchDomainsArr[key].split('.')[0],
            searchdomzone = searchDomainsArr[key].split('.')[1];
        searchZones += (searchdomzone != undefined && searchdomzone != null) ? ',' + searchdomzone : '';
        if (domName.indexOf(onedomainname) < 0) {
            domName.push(onedomainname);
        } else {
            loaderView();
            continue;
        }
        $.getJSON('/api/v1/shop/domains/check?domainList=' + onedomainname + '&zoneList=' + searchZones, function (data) {
            var classAv,
                classAv2;
            group1main = data['Content']['group1'];
            group2main = data['Content']['group2'];
            for (var key in group1main) {
                var status = group1main[key]['status'],
                    priceReg = group1main[key]['PriceRegister01'],
                    priceTrans = group1main[key]['PriceTransfer01'],
                    priceOld = group1main[key]['priceOld'],
                    prot = group1main[key]['idprotection'],
                    img = '',
                    priceOldString = '';
                if (key.slice(-1) == '.') {
                    continue;
                }
                if (!(key in contentMain)) {
                    contentMain[key] = group1main[key];
                }

                if (group1main[key]['img'] != null && group1main[key]['img'] != undefined)
                    img = '<img src="/upload/data/' + group1main[key]['img'] + '" />';

                if (priceOld != 0)
                    priceOldString = '<strike>€' + priceOld + '</strike> ';

                switch (status) {
                    case 'error':
                    case 'invalid domain':
                        classAv = 'invalid';
                        break;
                    case 'available':
                        classAv = 'available';
                        break;
                    case 'not available':
                    default:
                        classAv = 'registred';
                        break;
                }
                readyTable += '<tr class="tab-list__content-table-row tab-list__content-table-row__' + classAv + '">' +
                    '<td class="tab-list__content-table-cell" title="' + key + '">' +
                    '<span class="tab-list__content-table-cell-img">' + img + '</span>' + key.cutDomain() + '' +
                    '</td>' +
                    '<td class="tab-list__content-table-cell"><span class="status-content-tt" title="Status info">' + status + '</span></td>' +
                    '<td class="tab-list__content-table-cell tab-list__content-table-cell-price">' + priceOldString + '<span>€' + priceReg + '</span></td>' +
                    '<td class="tab-list__content-table-cell">' +
                    '<a href="#" class="tab-list__content-reg-this" data-prot="' + prot + '" data-domain="' + key + '" data-price="' + priceReg + '">' +
                    '<i class="b-icon"></i>Register' +
                    '</a>' +
                    '<a href="#" class="tab-list__content-its-my" data-prot="' + prot + '" data-domain="' + key + '" data-priceTrans="' + priceTrans + '">' +
                    '<i class="b-icon"></i>It\'s my domain</a>' +
                    '</td></tr>';
            }

            for (var key in group2main) {
                var status2 = group2main[key]['status'],
                    priceReg2 = group2main[key]['PriceRegister01'],
                    priceTrans2 = group2main[key]['PriceTransfer01'],
                    priceOld2 = group2main[key]['priceOld'],
                    prot2 = group2main[key]['idprotection'],
                    img2 = '';
                if (group2main[key]['img'] != null)
                    img2 = '<img src="/upload/data/' + group2main[key]['img'] + '" />';
                var promo = '';
                var priceOldString2 = '';
                if (priceOld2 != 0)
                    priceOldString2 = '<strike>€' + priceOld2 + '</strike> ';

                if (!(key in contentMain)) {
                    contentMain[key] = group2main[key];
                }
                if ('promo' in group2main[key])
                    promo = 'promoRow';
                switch (status2) {
                    case 'error':
                    case 'invalid domain':
                        classAv2 = 'invalid';
                        break;
                    case 'available':
                        classAv2 = 'available';
                        break;
                    case 'not available':
                    default:
                        classAv2 = 'registred';
                        break;
                }
                readyTable2 += '<tr class="tab-list__content-table-row tab-list__content-table-row__' + classAv2 + ' ' + promo + '">' +
                    '<td class="tab-list__content-table-cell" title="' + key + '"><span class="tab-list__content-table-cell-img">' + img2 + '</span>' + key.cutDomain() + '</td>' +
                    '<td class="tab-list__content-table-cell"><span class="status-content-tt" title="Status info">' + status2 + '</span></td>' +
                    '<td class="tab-list__content-table-cell tab-list__content-table-cell-price">' + priceOldString2 + ' <span>€' + priceReg2 + '</span></td>' +
                    '<td class="tab-list__content-table-cell">' +
                    '<a href="#" class="tab-list__content-reg-this" data-prot="' + prot2 + '" data-domain="' + key + '" data-price="' + priceReg2 + '" data-priceOld="' + priceOld2 + '">' +
                    '<i class="b-icon"></i>Register' +
                    '</a>' +
                    '<a href="#" class="tab-list__content-its-my" data-prot="' + prot2 + '" data-domain="' + key + '" data-priceTrans="' + priceTrans2 + '" >' +
                    '<i class="b-icon"></i>It\'s my domain</a>' +
                    '</td></tr>';

            }


            if (readyTable == '') {
                readyTable = '<tr><td colspan="4" align="center">The response is empty.</td></tr>';
                $('#result-table').addClass('emptyResp');
            }
            if (!$('#result-table').hasClass('emptyResp')) {
                PrependData('#result-table tbody', readyTable);
            } else {
                AddData('#result-table tbody', readyTable);
            }

            PrependData('#result-table2 tbody', readyTable2);


            bindTableClick();
        });
    }

    window.location.hash = '#domains_2';
    $('html, body').animate({
        scrollTop: $("#step2").offset().top
    }, 2000);

    return false;
});

/* Обработка кнопки "Register All" */
$('.tab-list__content-reg-all').on('click', '', function () {
    var $regAll = $(this).parents('.tab-list__content-table').find('.tab-list__content-reg-this:visible');
    $.each($regAll, function () {
        $(this).click();
    });
    return false;
});

/* Обработка переключения табов и подгрузки контента на втором шаге */
$('.tab-list__item').on('click', '', function () {
    var popularTable = '',
        thisid = $(this).attr('data-id');

    if (!$('#' + thisid + 'Table').hasClass('notEmpty') && $(this).attr('data-tab') != 1) {
        $.getJSON('/api/v1/shop/domains/check/groups?domainList=' + searchDomains + '&group=' + thisid + '&pg=1', function (data) {
            var classAv = '',
                activeTabContent = data['Content'];

            for (var key in activeTabContent) {
                var status = activeTabContent[key]['status'],
                    priceReg = activeTabContent[key]['PriceRegister01'],
                    priceTrans = activeTabContent[key]['PriceTransfer01'],
                    priceOld = activeTabContent[key]['priceOld'],
                    prot = activeTabContent[key]['idprotection'],
                    img = '',
                    priceOldString = '';


                if (!(key in contentMain)) {
                    contentMain[key] = activeTabContent[key];
                }

                if (activeTabContent[key]['img'] != null)
                    img = '<img src="http://ptkachenko.hostke.ru/upload/data/' + activeTabContent[key]['img'] + '" />';

                if (priceOld != 0)
                    priceOldString = '<strike>€' + priceOld + '</strike> ';

                switch (status) {
                    case 'error':
                    case 'invalid domain':
                        classAv = 'invalid';
                        break;
                    case 'available':
                        classAv = 'available';
                        break;
                    case 'not available':
                    default:
                        classAv = 'registred';
                        break;
                }
                popularTable += '<tr class="tab-list__content-table-row tab-list__content-table-row__' + classAv + '">' +
                    '<td class="tab-list__content-table-cell" title="' + key + '">' +
                    '<span class="tab-list__content-table-cell-img">' + img + '</span>' + key.cutDomain() + '' +
                    '</td>' +
                    '<td class="tab-list__content-table-cell"><span class="status-content-tt" title="Status info">' + status + '</span></td>' +
                    '<td class="tab-list__content-table-cell tab-list__content-table-cell-price">' + priceOldString + '<span>€' + priceReg + '</span></td>' +
                    '<td class="tab-list__content-table-cell">' +
                    '<a href="#" class="tab-list__content-reg-this" data-prot="' + prot + '" data-domain="' + key + '" data-price="' + priceReg + '">' +
                    '<i class="b-icon"></i>Register' +
                    '</a>' +
                    '<a href="#" class="tab-list__content-its-my" data-prot="' + prot + '" data-domain="' + key + '" data-priceTrans="' + priceTrans + '">' +
                    '<i class="b-icon"></i>It\'s my domain</a>' +
                    '</td></tr>';
            }
            $('#' + thisid + 'Table').addClass('notEmpty');
            AddData('#' + thisid + 'Table tbody', popularTable);
            bindTableClick();
        });
    }
});

/* Обработка совершения покупки на втором шаге, формирование третьего шага */
$('#buy').on('click', '', function () {
    if (reg.length) {
        var summaryRegData = '',
            reg_disabled = '';

        for (var key in reg) {
            var periodOptions = '';
            if (reg_prot[key] == 0) {
                reg_disabled = 'disabled="disabled"';
            } else {
                reg_disabled = '';
            }
            var pricesArr = pricesSumArr[reg[key]];
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
                '<td class="tab-list__content-table-cell" title="' + reg[key] + '">' + reg[key].cutDomain() + '</td>' +
                '<td class="tab-list__content-table-cell"><select class="table-select__item js-select" name="tbl-select-' + key + '" id="domains-register-period-select' + key + '" data_preset="' + key + '">' + periodOptions + '</select></td>' +
                '<td class="tab-list__content-table-cell"><input type="checkbox" class="js-switch"></td>' +
                '<td class="tab-list__content-table-cell"><input type="checkbox" class="js-switch" ' + reg_disabled + '></td>' +
                '</tr>';
        }
        window.location.hash = '#domains_3';
        AddData('#summaryRegTable tbody', summaryRegData);
        $('.js-select').select2();
    } else if (trans.length) {
        var summaryTransData = '';
        for (var key in trans) {
            summaryTransData += '<tr class="tab-list__content-table-row">' +
                '<td class="tab-list__content-table-cell" title="' + trans[key] + '">' + trans[key].cutDomain() + '</td>' +
                '<td class="tab-list__content-table-cell"><select class="table-select__item js-select" name="tbl-select-' + key + '" id="domains-register-period-select' + key + '1" data_preset="' + key + '1"><option value="0">1 year / €7</option><option value="1">2 year / €12</option><option value="2">3 year / €20</option></select></td>' +
                '<td class="tab-list__content-table-cell"><input type="checkbox" class="js-switch"></td>' +
                '<td class="tab-list__content-table-cell"><input type="checkbox" class="js-switch"></td>' +
                '</tr>';
        }
        window.location.hash = '#domains_3';
        AddData('#summaryRegTable tbody', summaryTransData);
    }

    /* Бинд библиотеки Switchery для переключателей на третьем шаге */
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
