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
    dnsRate = 10.56,
    orderGenArr = {
        'dns': {
            'ns1': '',
            'ns2': '',
            'ns3': '',
            'ns4': ''

        },
        'domains': {}
    },
    zoneExtFields = {},
    k = 0,
    pageDomCount = 20, // кол-во элементов подгружаемых в группах постранично
    searchZones = '',
    searchDomains = '',
    searchDomainsArr = '',
    emptyResult = true,
    domainsShow = false,
    isCut = false,
    fullAvDomList = {
        'result-table': '',
        'result-table2': '',
        'PopularTable': '',
        'PromoTable': '',
        'NationalTable': '',
        'ThematicTable': ''
    },
    fullAvDomPrices = {
        'result-table': 0,
        'result-table2': 0,
        'PopularTable': 0,
        'PromoTable': 0,
        'NationalTable': 0,
        'ThematicTable': 0
    };

window.location.hash = '#domains_1';

// Проверка наличия атрибута
$.fn.hasAttr = function (name) {
    return this.attr(name) !== undefined;
};

// Роутинг
window.addEventListener('hashchange', function () {
    switch (location.hash) {
        case '#domains_2':
            $('.domains-step2n3, #step2').css('display', 'inline-block');
            $('#step1, #step3').hide();
            $('.b-domains__title-main').html('REGISTER DOMAINS<br/>OR CONTINUE SEARCH');
            break;
        case '#domains_3':
            if (Object.keys(pricesSumArr).length) {
                $('.domains-step2n3, #step3').css('display', 'inline-block');
                $('#step1, #step2').hide();
                $('.b-domains__title-main').html('Choose additional services').css('width', '500px');
            }
            break;
        case '#domains_1':
        default:
            $('#step1').show();
            $('.domains-step2n3, #step2, #step3').hide();
            $('.b-domains__title-main').html('GET A PERFECT<br/>DOMAIN FOR YOUR PROJECT');
            break;
    }
});

// Очистка от html-тегов
String.prototype.stripTags = function () {
    return this.replace(/<\/?[^>]+>/g, '');
};

// Укорачивание длинных доменных имен
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

// Скрыть/показать блок
function toggleBlock(target) {
    var e = document.getElementById(target);
    e.style.display = (e.style.display == "block") ? "none" : "block";
}

// Добавление данных
function addData(target, data, action) {
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

// Операции с итоговой суммой в корзине
function summaryPriceCalc(num, operation) {
    if (operation == '+') {
        summaryPrice = (parseFloat(summaryPrice) + parseFloat(num)).toFixed(2);
    } else {
        summaryPrice = (parseFloat(summaryPrice) - parseFloat(num)).toFixed(2);
    }
    if (summaryPrice == 0) {
        $('#Summa').html('Empty Cart');
    } else {
        $('#Summa').html('€' + summaryPrice);
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
            regPeriod = groupDomain.hasOwnProperty('RegisterPeriod') ? groupDomain['RegisterPeriod'] : '',
            img = (groupDomain['img'] != null && groupDomain['img'] != 'undefined' && groupDomain['img'] != '') ? '<img src="/upload/data/' + groupDomain['img'] + '" />' : '',
            promo = ('promo' in data[name]) ? 'promoRow' : '',
            periodOptions = '',
            dnsFlag = 1,
            cutName = name.cutDomain();

        if (groupDomain['status'] == 'available') {
            domainsList.push(name);
            domainsPrice = domainsPrice + groupDomain['PriceRegister01'];
            domainsShow = true;
        }

        if (regPeriod != '') {
            if (regPeriod.toString().indexOf(',') >= 0) {
                var rpArray = regPeriod.split(',');
                for (var rpkey in rpArray) {
                    var prNum = rpArray[rpkey] / 12,
                        prPeriod = (prNum == 1 ? prNum + ' year' : prNum + ' years'),
                        prPrice = groupDomain['PriceRegister'.concat((prNum <= 9) ? '0'.concat(prNum) : prNum)];
                    periodOptions += '<option value="' + prNum + '">' + prPeriod + ' / €' + prPrice + '</option>';
                }
            } else {
                var prNum = regPeriod / 12,
                    prPeriod = (prNum == 1 ? prNum + ' year' : prNum + ' years'),
                    prPrice = groupDomain['PriceRegister'.concat((prNum <= 9) ? '0'.concat(prNum) : prNum)];
                periodOptions += '<option value="' + prNum + '">' + prPeriod + ' / €' + prPrice + '</option>';
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
            '<a href="#" class="tab-list__content-reg-this" data-dns="' + dnsFlag + '" data-domain="' + name + '" data-rowN="' + k + '"><i class="b-icon"></i>Add to cart</a>' +
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
        addData(target, readyTable, 'append');
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
    } else if (!domainsShow) {
        if (!$('.resultContWrong').length) {
            $('.resultCont').hide().after('<div class="resultContWrong">Sorry! This name is already taken.</div>');
            loaderView('hide');
        }
    } else {
        if (!$('#result-table').find('.tab-list__content-table-row__available').length)
            $('#result-table-message').html('Sorry! This name is already taken.');
        else
            $('#result-table-message').html('Congratulations! You can register the domains of your choice.');
        $('.resultCont').show();
        $('.resultContWrong').remove();
    }

    if (target != '#result-table2')
        $('.regAllContainer').remove();

    fullAvDomList[target.slice(1)] += domainsList.join(', ');
    fullAvDomPrices[target.slice(1)] += domainsPrice;
    var tableDomList = fullAvDomList[target.slice(1)],
        tableDomPrices = fullAvDomPrices[target.slice(1)],
        qDom = ((!tableDomList.length) ? 0 : (tableDomList.indexOf(',') >= 0) ? (tableDomList.split(',')).length : 1),
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
        $(target).next('.nextPg').after('<div class="regAllContainer for' + target.slice(1) + '"><div class="regAllContent">' +
            '<div class="regAllTitle">Register ' + qDom + numVariation + '  for one year for €' + tableDomPrices.toFixed(2) + ':</div>' +
            tableDomList + '</div>' +
            '<a href="#" data-tname="' + target + '" class="regAllButton"><i class="b-icon"></i>Register all</a>' +
            '</div>');
    }
    $('.js-select').select2({
        minimumResultsForSearch: -1
    });
}

// Справочник шаблонов для доп. полей
function createFields(json) {
    var htmlResult = '';
    for (var key in json) {
        var item = json[key],
            optionsArr = {};
        switch (item['Type']) {
            case 'text':
                htmlResult += '<div class="extFieldRow">';
                htmlResult += '<label>' + item['Name'] + '</label><input type="text" name="' + item['Name'] + '" size="' + item['Size'] + '" placeholder="' + item['Default'] + '" ' + (item['Required'] ? 'required /> <span class="extFieldReq">*</span>' : ' />');
                htmlResult += '</div>';
                break;
            case 'tickbox':
                htmlResult += '<div class="extFieldRow">';
                htmlResult += '<label>' + item['Name'] + '</label><input type="checkbox" name="' + item['Name'] + '"  />' + ((item['Description'] != undefined && item['Description'] != null) ? ' <span>' + item['Description'] + '</span>' : '');
                htmlResult += '</div>';
                break;
            case 'radio':
                optionsArr = item['Options'].split(',');
                htmlResult += '<div class="extFieldRow"><label>' + item['Name'] + '</label>';
                for (var key in optionsArr) {
                    htmlResult += '<input type="radio" name="' + item['Name'] + '" value="' + optionsArr[key] + '" /><label>' + optionsArr[key] + '</label>';
                }
                htmlResult += '</div>';
                break;
            case 'dropdown':
                optionsArr = item['Options'].split(',');
                htmlResult += '<div class="extFieldRow"><label style="padding-right: 10px;">' + item['Name'] + '</label><select class="js-select" name="' + item['Name'] + '">';
                for (var key in optionsArr) {
                    htmlResult += '<option value="' + optionsArr[key] + '" >' + optionsArr[key] + '</option>';
                }
                htmlResult += '</select></div>';
                break;
            case 'display':
            default:
                htmlResult += '<div class="extFieldInfo">' + item['Name'] + ': ' + item['Default'] + '</div>';
                break;
        }
    }
    return htmlResult;
}

// Подгрузка цены на dns-хостинг
$.getJSON('/api/v1/shop/domains/dns/price', function (data) {
    if (!data['ErrorStatus'])
        dnsRate = data['Content'];
});

// Подгрузка инфы для доп полей
$.getJSON('/api/v1/domains/advanced/field', function (data) {
    var zones = data['Content'];
    for (var key in zones) {
        zoneExtFields[key] = createFields(zones[key]);
    }
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
            price = items[i].PriceRegister01;


        console.log(1);
        ready += '<label class="domain-zone__item" for="regular_check-' + i + '">' +
            '<span class="domain-zone__item-title">' + name + '</span><br>' +
            '<input data-name="' + name + '" class="hidden-input" name="check-' + i + '" type="checkbox" id="regular_check-' + i + '"/>' +
            '<span class="domain-zone__item-price">€' + price + '</span>' +
            '</label>';
    }
    addData('.domain-zone', ready, 'add');
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
            price = items[a].PriceRegister01,
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
    addData('.domains-check__row', readyPromo, 'add');
});

// Вывод еще одной строки доменных зон в область под поиском
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
            var price = items[i].PriceRegister01;
            ready += '<label class="domain-zone__item" for="regular_check-' + i + '">' +
                '<span class="domain-zone__item-title">' + name + '</span><br>' +
                '<input data-name="' + name + '" class="hidden-input" name="check-' + i + '" type="checkbox" id="regular_check-' + i + '"/>' +
                '<span class="domain-zone__item-price">€' + price + '</span>' +
                '</label>';
        }
        addData('.domain-zone', ready, 'append');
    });
    return false;
});

// Вывод еще одной строки доменных зон в Special Offers
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
            var price = items[a].PriceRegister01;
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
        addData('.domains-check__row', readyPromo, 'append');
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
        $firstTab = $('.domains-step2__tab .tab-list__item[data-tab="1"]'),
        inputZone = {};

    loaderView('show');

    $('.tab-list__content-table').removeClass('notEmpty');

    if (!$firstTab.hasClass('current'))
        $firstTab.trigger('click');

    searchDomains = ($('.search-bar__input:visible').val()).replace(/\n/g, ',');
    if (searchDomains.substr(-1, 1) == ',') {
        searchDomains = searchDomains.substr(0, -1);
    }
    searchDomainsArr = searchDomains.split(',');

    searchZones = '';
    $.each($checkedInput, function () {
        searchZones += $(this).data('name').replace('.', '') + ',';
    });
    if (searchDomainsArr.indexOf('.') >= 0) {
        inputZone = searchDomainsArr.split('.');
        searchZones += inputZone[1];
    }
    searchZones = searchZones.slice(0, -1);

    // Возвращаем строчный вид поиска на 2 шаге
    if (!$('input.search-bar__input').is(':visible')) {
        $('.search-bar__button-hide').trigger('click');
    }

    // Чистим поля поиска
    $('input.search-bar__input, textarea.search-bar__input').val('');

    $('.search-bar .b-submit').addClass('search-bar__submit__disabled');

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

// Добавление в корзину
$(document).on('click', 'a.tab-list__content-reg-this', function () {
    var $domain = $(this).attr('data-domain'),
        cutName = $domain.cutDomain(),
        $rowN = $(this).attr('data-rown'),
        $cartRowN = $('#domains-register-table').find('td[data-rown=' + $rowN + ']'),
        $period = $('#regPeriod' + $rowN).val(),
        $priceSplit = ($('#regPeriod' + $rowN + ' option:selected').html()).split('€'),
        $price = $priceSplit[1],
        $dns = parseInt($(this).attr('data-dns')),
        $section = $('#registerSection');

    if ($domain in contentMain) {
        if (!($domain in pricesSumArr)) {
            $('.tab-list__content-reg-this[data-domain="' + $domain + '"]').parents('.tab-list__content-table-row__available').addClass('selected_row');
            pricesSumArr[$domain] = contentMain[$domain];
            pricesSumArr[$domain]['action'] = 'reg';
            pricesSumArr[$domain]['period'] = $period;
            pricesSumArr[$domain]['price'] = $price;
            pricesSumArr[$domain]['dnsmanagement'] = $dns;

            if (!$section.is(':visible'))
                $section.addClass('visible_section');

            $('#domains-register-table').find('tbody').append(
                '<tr class="domains-step__summary-table-row">' +
                '<td class="domains-step__summary-table-cell domain-title-show' + (!isCut ? '' : ' js-tooltip" title="' + $domain) + '">' +
                (!isCut ? $domain : cutName) + '</td>' +
                '<td class="domains-step__summary-table-cell remove-row" data-rowN="' + $rowN + '" data-domain="' + $domain + '">€' + $price + '</td>' +
                '</tr>');
            summaryPriceCalc($price, '+');
        } else {
            pricesSumArr[$domain]['period'] = $period;
            summaryPrice = (parseFloat(summaryPrice) - parseFloat(pricesSumArr[$domain]['price']) + parseFloat($price)).toFixed(2);
            pricesSumArr[$domain]['price'] = $price;
            $cartRowN.html('€' + $price);
            $('#Summa').html('€' + summaryPrice);
        }
    }
    return false;
});

// Удаление из корзины
$(document).on('click', '.domains-step__summary-table .remove-row', function () {
    var $rowCart = $(this).parents('.domains-step__summary-table-row'),
        $section = $(this).parents('.domains-step__summary-section'),
        $price = parseFloat($(this).html().slice(1)),
        $rowN = $(this).attr('data-rown');
    if ($(this).hasAttr('data-domain')) {
        var $domain = $(this).attr('data-domain');

        delete pricesSumArr[$domain];
        if ($(this).hasAttr('data-dns'))
            $('.domains-step__summary-table-row[data-linkDom="dns_' + $domain + '"]').find('.remove-row').trigger('click');
        if ($(this).hasAttr('data-idprot'))
            $('.domains-step__summary-table-row[data-linkDom="idprot_' + $domain + '"]').find('.remove-row').trigger('click');

        $('#additServTable').find('.tab-list__content-table-row[data-domain="' + $domain + '"]').remove();
        $('#domains-infoExtItem').find('.domains-infoExtItem[data-domain="' + $domain + '"]').remove();
        $('.tab-list__content-reg-this[data-domain="' + $domain + '"]').parents('.selected_row').removeClass('selected_row');

    } else {
        var linkDom = $(this).parents('.domains-step__summary-table-row').attr('data-linkDom'),
            linkDomS = linkDom.split('_'),
            type = linkDomS[0],
            domain = linkDomS[1],
            $input = $('input[data-linkDom="' + linkDom + '"]'),
            $fakeInput = $input.next();
        $('#domains-register-table').find('.remove-row[data-domain="' + domain + '"]').removeAttr('data-' + type);
        if ($input.is(':checked')) {
            $fakeInput.trigger('click');
        }
    }

    $rowCart.remove();
    if ($section.find('td').length == 0)
        $section.removeClass('visible_section');

    summaryPriceCalc($price, '-');
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

// Переход на третий шаг и отправка данных в биллинг
$('#buy').on('click', '', function () {
    var summaryData = {},
        additServContent = '',
        domains = Object.keys(pricesSumArr).join(', '),
        optionId = 0,
        summaryConfig = '',
        successLink = 'https://bill.hostkey.com/cart.php?a=add&currency=2&pid=564&billingcycle=monthly';
    if (Object.keys(pricesSumArr).length) {
        var regPeriod = 0,
            dnsPeriod = 0,
            dnsPrice = 0,
            idProtPrice = 0,
            idProt = 0,
            dnsDisabled = '',
            idProtDisabled = '',
            domainSplit = {},
            currentZone = '',
            extFieldsArr = {},
            extFieldsStr = '';

        if (window.location.hash != '#domains_3') {
            summaryData = {};
            summaryData['domainreg'] = true;

            toggleBlock('searchBarContainer');
            window.location.hash = '#domains_3';

            for (var key in pricesSumArr) {
                if (pricesSumArr[key]['action'] == 'reg' && pricesSumArr[key]['status'] == 'available') {
                    regPeriod = pricesSumArr[key]['period'];
                    dnsPeriod = regPeriod;
                    dnsPrice = dnsPeriod * dnsRate;
                    idProtPrice = dnsPeriod * 4;
                    domainSplit = key.split('.');
                    currentZone = '.' + domainSplit[1];
                    if (currentZone in zoneExtFields) {
                        extFieldsArr[key] = zoneExtFields[currentZone];
                    }

                    summaryData['domains[' + key + ']'] = key;
                    summaryData['domainsregperiod[' + key + ']'] = regPeriod;
                    summaryData['domainsregprice[' + key + ']'] = pricesSumArr[key]['price'];

                    dnsDisabled = (pricesSumArr[key]['dnsmanagement']) ? '' : 'disabled="disabled"';
                    idProtDisabled = (pricesSumArr[key]['idprotection']) ? '' : 'disabled="disabled"';

                    // Отрисовка таблицы доп. сервисов
                    additServContent += '<tr class="tab-list__content-table-row" data-domain="' + key + '">' +
                        '<td class="tab-list__content-table-cell' + (!isCut ? '' : ' js-tooltip" title="' + key) + '">' + key.cutDomain() + '</td>' +
                        '<td class="tab-list__content-table-cell">' + regPeriod + ' year' + (regPeriod > 1 ? 's' : '') + '</td>' +
                        '<td class="tab-list__content-table-cell"><input type="checkbox" data-linkDom="idprot_' + key + '" data-price="' + idProtPrice + '" class="js-switch" ' + idProtDisabled + '></td>' +
                        '<td class="tab-list__content-table-cell"><input type="checkbox" data-linkDom="dns_' + key + '" data-price="' + dnsPrice + '" class="js-switch" ' + dnsDisabled + '></td>' +
                        '</tr>';

                }
            }

            addData('#additServTable', additServContent, 'add');
            if (!$.isEmptyObject(extFieldsArr)) {
                for (var key in extFieldsArr) {
                    extFieldsStr += '<div class="domains-infoExtItem" data-domain="' + key + '">' +
                        '<p class="domains-infoExtItemTitle">' + key + '</p>' +
                        extFieldsArr[key] +
                        '</div>';
                }
                addData('.domains-infoExtFormat', extFieldsStr, 'append');
                $('#infoBlockExtFields').show();
            }

            $('.js-select').select2({
                minimumResultsForSearch: -1
            });
            // Бинд библиотеки Switchery для переключателей на третьем шаге
            var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch')),
                switchery = {};
            elems.forEach(function (html) {
                if ($(this).attr('disabled') != 'disabled')
                    switchery = new Switchery(html, {color: '#945ae0'});
                else
                    switchery = new Switchery(html, {color: '#c4a8ec', disabled: true});
            });
        } else {
            for (var key in pricesSumArr) {
                if (pricesSumArr[key]['action'] == 'reg' && pricesSumArr[key]['status'] == 'available') {
                    regPeriod = pricesSumArr[key]['period'];
                    dnsPeriod = (!pricesSumArr[key]['dnsmanagement'] || !pricesSumArr[key]['dnsflag'] ? 0 : regPeriod);
                    idProt = (!pricesSumArr[key]['idprotflag'] ? 0 : pricesSumArr[key]['idprotection']);

                    orderGenArr['domains'][key] = {
                        'advanced': {
                            'Name1': '',
                            'Name2': ''
                        },
                        'periodReg': parseInt(regPeriod * 12),
                        'periodTrans': 0,
                        'periodRenew': 0,
                        'idprotection': idProt,
                        'dns': dnsPeriod
                    };
                    summaryConfig += 'Register domain: ' + key + '<br/>' + (dnsPeriod > 0 ? '+ DNS hosting<br/>' : '') + (idProt > 0 ? '+ WHOIS privacy<br/>' : '') + '<b>Period: ' + regPeriod + ' year' + (regPeriod > 1 ? 's' : '') + ' </b><br/>';
                }
            }
            if (!$('.domains-infoExtItem').find('input:required').val() != '' && !$('.domains-infoExtItem').find('input:required').val() != undefined) {
                $.ajax({
                    url: '/api/v1/domains/order',
                    type: 'POST',
                    data: JSON.stringify(orderGenArr),
                    dataType: 'JSON',
                    success: function (data) {
                        if (data['ErrorStatus'] == false) {
                            optionId = data['Content']['OptionID'];
                            $.redirect(successLink + '&configoption[858]=' + optionId + '&customfield[348]=' + summaryConfig, '', 'POST', '_self');
                        } else {
                        }
                    }
                });
            } else {
                var errorField = '';
                $.each($('.domains-infoExtItem').find('input:required'), function () {
                    if ($(this).val() == '') {
                        $(this).addClass('errorInput');
                        errorField += $(this).attr('name') + ' is required / ';
                    }
                });
                $('.domains-infoBlockSubtitle').after('<div class="errorFieldsList">' + errorField.slice(0, -3) + '</div>');
            }
        }
    }
});

// Добавление доп. опций в корзину на третьем шаге
$(document).on('change', '.js-switch', function () {
    var linkDom = $(this).attr('data-linkDom').split('_'),
        type = linkDom[0],
        domain = linkDom[1],
        price = $(this).attr('data-price'),
        cartRow = '<tr class="domains-step__summary-table-row" data-linkDom="' + type + '_' + domain + '">' +
            '<td class="domains-step__summary-table-cell domain-title-show">' + ((type == "dns") ? 'DNS hosting' : 'WHOIS privacy') + '</td>' +
            '<td class="domains-step__summary-table-cell remove-row">€' + price + '</td>' +
            '</tr>';
    if ($(this).is(':checked')) {
        pricesSumArr[domain][type + 'Flag'] = 1;
        $('#domains-register-table').find('.remove-row[data-domain="' + domain + '"]').attr('data-' + type, type).parent().after(cartRow);
        summaryPriceCalc(price, '+');
    } else {
        pricesSumArr[domain][type + 'Flag'] = 0;
        $('#domains-register-table').find('.domains-step__summary-table-row[data-linkDom="' + type + '_' + domain + '"] .remove-row').trigger('click');
    }
});

// Бинд библиотеки tooltip для всплывающих подсказок
$('table').tooltip({
    items: '.js-tooltip'
});