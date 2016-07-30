// Приведение методов к более удобному формату
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

var i,
    a,
    contentMain = {},
    pricesSumArr = {},
    summaryPrice = 0,
    k = 0,
    pageDomCount = 20, // кол-во элементов подгружаемых в группах постранично
    searchZones = '',
    searchDomains = '',
    searchDomainsArr = '',
    emptyResult = true,
    isCut = false;

window.location.hash = '#domains_1';

// Функция, отслеживающая переход по шагам
window.addEventListener('hashchange', function () {
    switch (location.hash) {
        case '#domains_2':
            $('.domains-step2n3, #step2').css('display', 'inline-block');
            $('#step1, #step3').hide();
            $('.b-domains__title-main').html('REGISTER DOMAINS<br/>OR CONTINUE SEARCH');
            break;
        case '#domains_1':
        default:
            $('#step1').show();
            $('.domains-step2n3, #step2, #step3').hide();
            $('.b-domains__title-main').html('GET A PERFECT<br/>DOMAIN FOR YOUR PROJECT');
            break;
    }
});

// Функция добавления данных
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

// Функция очистки от html-тегов
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
        cutName = splitName[0].substr(0, 10) + '...' + splitName[1];
    }
    return cutName;
};

// Обработчик лоадера
function loaderView(action) {
    if (action == 'hide') {
        $('.loader-view').hide();
        $('.b-domains__container').removeClass('overlay-view');
    } else {
        $('.loader-view').show();
        $('.b-domains__container').addClass('overlay-view');
    }
}

// Обработчик полученных данных для 2 шага
function genDomainsTable(target, data) {
    var readyTable = '',
        domainsList = [],
        domainsPrice = 0,
        readyTableHeader = '<thead><tr>' +
            '<th width="250" class="tab-list__content-table-cell">Domain</th>' +
            '<th width="150" class="tab-list__content-table-cell">Status</th>' +
            '<th width="220" class="tab-list__content-table-cell">Price</th>' +
            '<th width="250" class="tab-list__content-table-cell"><a href="#" data-tname="' + target + '" class="tab-list__content-reg-all"><i class="b-icon"></i>Register all<span class="tab-list__content-reg-help js-tooltip" title="All available domains will be added to the shopping cart."></span></a></th>' +
            '</tr></thead><tbody>',
        readyTableFooter = '</tbody>';
    for (var key in data) {
        k++;
        if (key.substr(-1) == '.' || key == '-')
            continue;

        var name = key,
            groupDomain = data[name],
            statusClass = (groupDomain['status'] == 'available') ? 'available' : 'invalid',
            statusDesc = groupDomain['description'],
            status = groupDomain['status'],
            img = (groupDomain['img'] != null && groupDomain['img'] != 'undefined' && groupDomain['img'] != '') ? '<img src="/upload/data/' + groupDomain['img'] + '" />' : '',
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
            status + (( statusDesc != null && statusDesc !== 'undefined') ? '<span class="status-content-tt js-tooltip" title="' + statusDesc + '"></span>' : '') +
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
        $(target).addClass('emptyResp').prev('p').addClass('hiddenp');
    } else if ($(target).is(':empty')) {
        emptyResult = false;
        readyTable = readyTableHeader + readyTable + readyTableFooter;
        $(target).removeClass('emptyResp').prev('p').removeClass('hiddenp');
    }

    if (!$(target).hasClass('emptyResp')) {
        AddData(target, readyTable, 'append');
        $(target).addClass('notEmpty');
    }


    if ($('#result-table').hasClass('emptyResp') && $('#result-table2').hasClass('emptyResp')) {
        $('.resultCont').hide();
        $('.resultCont').after('<div class="resultContWrong">Wrong request. Try again.</div>');
        loaderView('hide');
        setTimeout(function () {
            $('#result-table').slideUp('slow').fadeOut(function () {
                window.location.reload();
            });
        }, 1000);
    } else if (!($('#result-table').find('.tab-list__content-table-row__available').length && $('#result-table2').find('.tab-list__content-table-row__available').length) || !$('.resultContWrong').length) {
        $('.resultCont').hide().after('<div class="resultContWrong">Sorry! This name is already taken.</div>');
        loaderView('hide');
    } else {
        $('.resultCont').show();
        $('.resultContWrong').remove();
    }

    var qDom = domainsList.length,
        numVariation = ' domains';
    if (qDom > 0) {
        switch (qDom) {
            case 1:
                numVariation = ' domain';
                break;
            default:
                numVariation = ' domains';
                break;

        }

        $(target).next('.nextPg').after('<div class="regAllContainer"><div class="regAllContent">' +
            '<div class="regAllTitle">Register ' + qDom + numVariation + '  for one year for €' + domainsPrice.toFixed(2) + ':</div>' +
            domainsList.join(', ') + '</div>' +
            '<a href="#" data-tname="' + target + '" class="regAllButton"><i class="b-icon"></i>Register all</a>' +
            '</div>');
    }
    $('.js-select').select2({
        minimumResultsForSearch: -1
    });
}

// Обработчик добавления в корзину
$(document).on('click', 'a.tab-list__content-reg-this', function () {
    var $domain = $(this).attr('data-domain'),
        cutName = $domain.cutDomain(),
        $rowN = $(this).attr('data-rown'),
        $cartRowN = $('#domains-register-table').find('td[data-rown=' + $rowN + ']'),
        $period = $('#regPeriod' + $rowN).val(),
        $priceSplit = ($('#regPeriod' + $rowN + ' option:selected').html()).split('€'),
        $price = $priceSplit[1],
        $section = $('#registerSection');

    if ($domain in contentMain) {
        if (!($domain in pricesSumArr)) {
            $('.tab-list__content-reg-this[data-domain="' + $domain + '"]').parents('.tab-list__content-table-row__available').addClass('selected_row');
            pricesSumArr[$domain] = contentMain[$domain];
            pricesSumArr[$domain]['action'] = 'reg';
            pricesSumArr[$domain]['period'] = $period;
            pricesSumArr[$domain]['price'] = $price;

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
        } else {
            pricesSumArr[$domain]['period'] = $period;
            summaryPrice = (parseFloat(summaryPrice) - parseFloat(pricesSumArr[$domain]['price'])) + parseFloat($price);
            pricesSumArr[$domain]['price'] = $price;
            $cartRowN.html('€' + $price);
            $('#Summa').html('€' + summaryPrice);
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

// Начальная загрузка области Special offers
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

// Вывод полного списка доменных зон в область под поиском
$('#domain-zone__more').on('click', '', function () {
    var self = $(this);
    $.getJSON('/api/v1/shop/domains/zone/list?groups=top100', function (data) {
        var items = data['Content'];
        var ready = '';
        var iter = i + 6;
        if (items.length <= iter) {
            iter = items.length;
            self.hide();
        }
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
    return false;
});

// Вывод полного списка доменных зон в Special Offers
$('#domains-check__more').on('click', '', function () {
    var self = $(this);
    $.getJSON('/api/v1/shop/domains/zone/list?groups=promo', function (data) {
        var items = data['Content'];
        var readyPromo = '';
        var iter = a + 4;
        if (items.length <= iter) {
            iter = items.length;
            self.hide();
        }
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
    return false;
});

// Чистка области поиска от лишних символов на лету
$('.search-bar__input').on('keyup', function (e) {
    var svalue = $(this).val().replace(/[^a-zA-Z0-9-^.\n]/g, '');
    // var svalue = $(this).val().replace(/[^a-zA-Zа-яА-Я0-9-^.\n]/g, ''); // буквы всех алфавитов
    var nvalue = $(this).val().replace(/[а-яА-Я,;!@#$%^&*()_=+<>/\\'"\[\]\{\}№:? ]/g, '\n');
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

// Переключение поисковой области в многострочный режим
$('.search-bar__button-bulk').on('click', '', function () {
    $('.search-bar__input').toggleClass('search-bar__input-hidden');
    $('.search-bar__button-hide').show();
    $('.search-bar__input:visible').val($('.search-bar__input').not(':visible').val());
    $(this).hide();
});

// Переключение поисковой области в однострочный режим
$('.search-bar__button-hide').on('click', '', function () {
    $('.search-bar__input').toggleClass('search-bar__input-hidden');
    $('.search-bar .b-submit').addClass('search-bar__submit__disabled');
    $('.search-bar__button-bulk').show();
    $('.search-bar__input:visible').val('');
    $(this).hide();
});

// Запуск поиска и переход на второй шаг
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
        $('.search-bar__button-hide').trigger('click');
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

        });

    }

    window.location.hash = '#domains_2';

    return false;
});

// Обработка кнопки "Register All"
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

// Обработка переключения табов и подгрузки контента на втором шаге
$('.tab-list__item').on('click', '', function () {
    var popularTable = '',
        self = $(this),
        thisid = self.attr('data-id'),
        target = '#' + thisid + 'Table';
    if (!$(target).hasClass('notEmpty') && $(this).attr('data-tab') != 1) {

        var clearDomainsArr = [],
            clearDomains = '';
        loaderView('show');
        searchDomainsArr.forEach(function (item) {
            var clearName = item.split('.');
            clearDomainsArr.push(clearName[0]);
        });

        clearDomains = clearDomainsArr.join(',');

        $.getJSON('/api/v1/shop/domains/check/groups?domainList=' + clearDomains + '&group=' + thisid + '&pg=1', function (data) {
            var activeTabContent = data['Content'];
            genDomainsTable(target, activeTabContent);
            $(target).addClass('notEmpty');
            if (Object.keys(data['Content']).length % 20 == 0)
                $('.tab-list__content.current .nextPg').show();
            else
                $('.tab-list__content.current .nextPg').hide();
        });
        // Обработка постраничника в группах
        $('.nextPg').on('click', '', function () {
            var pg = parseInt(self.attr('data-pg')) + 1;
            self.attr('data-pg', pg);
            loaderView('show');
            $.getJSON('/api/v1/shop/domains/check/groups?domainList=' + clearDomains + '&group=' + thisid + '&pg=' + pg, function (data) {
                var activeTabContent = data['Content'];
                genDomainsTable(target, activeTabContent);
                if (Object.keys(data['Content']).length % pageDomCount == 0)
                    $('.tab-list__content.current .nextPg').show();
                else
                    $('.tab-list__content.current .nextPg').hide();
            });
        })

    }

});

// Переход на третий шаг
$('#buy').on('click', '', function () {
    var summaryData = {},
        domains = Object.keys(pricesSumArr).join(', ');
    if (Object.keys(pricesSumArr).length) {
        summaryData = {};
        summaryData['domainreg'] = true;
        for (var key in pricesSumArr) {
            if (pricesSumArr[key]['action'] == 'reg' && pricesSumArr[key]['status'] == 'available') {
                summaryData['domains[' + key + ']'] = key;
                summaryData['domainsregperiod[' + key + ']'] = pricesSumArr[key]['period'];
                summaryData['domainsregprice[' + key + ']'] = pricesSumArr[key]['price'];
            }
        }
        $.redirect('https://bill.hostkey.com/cart.php?a=add&domain=register&currency=2', summaryData, 'POST', '_blank');
    }
});

// Удаление выбранного домена из корзины на 2 шаге
$(document).on('click', '.domains-step__summary-table .remove-row', function () {
    var $rowCart = $(this).parents('.domains-step__summary-table-row'),
        $domain = $(this).attr('data-domain'),
        $section = $(this).parents('.domains-step__summary-section'),
        $price = parseFloat($(this).html().slice(1)),
        $rowN = $(this).attr('data-rown');

    delete pricesSumArr[$domain];
    $rowCart.remove();
    $('.tab-list__content-reg-this[data-domain="' + $domain + '"]').parents('.selected_row').removeClass('selected_row');
    if ($section.find('td').length == 0)
        $section.removeClass('visible_section');
    summaryPrice = parseFloat(summaryPrice.toFixed(2)) - parseFloat($price.toFixed(2));
    $('#Summa').html('€' + summaryPrice.toFixed(2));
    if (summaryPrice == 0)
        $('#Summa').html('Empty Cart');
});

// Бинд библиотеки tooltip для всплывающих подсказок
$('body').tooltip({
    selector: '.js-tooltip'
});