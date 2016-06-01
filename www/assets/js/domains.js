var i, a;
var reg = [],
    trans = [];
var summaryPrice = 0;
var searchZones = '';

function AddData(target, data) {
    $(target).html(data);
}

function AppendData(target, data) {
    $(target).append(data);
}

String.prototype.stripTags = function () {
    return this.replace(/<\/?[^>]+>/g, '');
};

function bindTableClick() {
    $('.tab-list__content-table-row__available').on('click', 'a.tab-list__content-reg-this', function () {
        var domain = $(this).attr('data-domain');
        var price = $(this).attr('data-price');
        var searchThis = reg.indexOf(domain);
        if (searchThis !== undefined && searchThis != null) {
            if (searchThis < 0) {
                reg.push(domain);
                $('#domains-register-table tbody').append(
                    '<tr class="domains-step2__summary-table-row">' +
                    '<td class="domains-step2__summary-table-cell">' + domain + '</td>' +
                    '<td class="domains-step2__summary-table-cell">€' + price + '</td>' +
                    '</tr>');

                summaryPrice += parseInt(price);
                $('#Summa').html('€' + summaryPrice);
            }
        }
        return false;
    });
}

$('#domain-zone__more').on('click', function () {
    $.getJSON('/api/v1/shop/domains/zone/list?groups=top100', function (data) {
        var items = data['Content'];
        var ready = '';
        var iter = items.length;
        for (i; i < iter; i++) {
            var name = items[i].Name;
            var price = items[i].PriceRegister;
            ready += '<label class="domain-zone__item" for="regular_check-' + i + '">' +
                '<span class="domain-zone__item-title">' + name + '</span><br>' +
                '<input class="hidden-input" name="check-' + i + '" type="checkbox" id="regular_check-' + i + '"/>' +
                '<span class="domain-zone__item-price">€' + price + '</span>' +
                '</label>';
        }
        AppendData('.domain-zone', ready);
    });
    $(this).hide();
    return false;
});

$('#domains-check__more').on('click', function () {
    $.getJSON('/api/v1/shop/domains/zone/list?groups=promo', function (data) {
        var items = data['Content'];
        var readyPromo = '';
        var iter = items.length;
        for (a; a < iter; a++) {
            var name = items[a].Name;
            var img = '<img src="http://ptkachenko.hostke.ru/upload/data/' + items[a].Img + '" title="' + name + '"/>';
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
                '<span class="fake-checkbox-label__box js-check"></span><input class="hidden-input" name="check-1" type="checkbox"/>' +
                '<div class="domains-check__item-register">register</div><div class="domains-check__item-order">order</div>' +
                '</label>';

        }
        AppendData('.domains-check__row', readyPromo);
    });
    $(this).hide();
    return false;
});
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
        var img = '<img src="http://ptkachenko.hostke.ru/upload/data/' + items[a].Img + '" title="' + name + '"/>';
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

$('.search-bar__input:visible').on('keyup', function (e) {
    var svalue = $(this).val().replace(/[^a-zA-Z0-9-^.\n]/gim, '');
    $(this).val(svalue);

    if (e.keyCode == 13)
        $(this).addClass('search-bar__input-pad');
});

$('.search-bar__button-bulk').on('click', '', function (e) {
    $('.search-bar__input').toggleClass('search-bar__input-hidden');
});

$('.search-bar .b-submit').on('click', '', function (e) {
    var $checkedInput = $('.hidden-input:checked');
    searchZones = '';
    var readyTable = '';
    var readyTable2 = '';
    $.each($checkedInput, function () {
        searchZones += $(this).data('name').replace('.', '') + ',';
    });
    searchZones = searchZones.slice(0, -1);
    var searchDomains = ($('.search-bar__input:visible').val()).replace(/\n/g, ',');
    if (searchDomains.substr(-1, 1) == ',') {
        searchDomains = searchDomains.substr(0, -1);
    }
    var searchDomainsArr = searchDomains.split(',');
    for (key in searchDomainsArr) {
        var onedomainname = searchDomainsArr[key];
        $.getJSON('/api/v1/shop/domains/check?domainList=' + onedomainname + '&zoneList=' + searchZones, function (data) {
            var items = data['Content']['group1'];
            var itemsTop = data['Content']['group2'];
            var classAv;
            var classAv2;
            for (key in items) {
                var status = items[key]['status'];
                var priceReg = items[key]['priceRegister'];
                var priceTrans = items[key]['priceTransfer'];
                var priceRenew = items[key]['priceRenew'];
                var priceOld = items[key]['priceOld'];
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
                    '<td class="tab-list__content-table-cell">' + key + '</td>' +
                    '<td class="tab-list__content-table-cell">' + status + '</td>' +
                    '<td class="tab-list__content-table-cell">' +
                    '<a href="#" class="tab-list__content-reg-this" data-domain="' + key + '" data-price="' + priceReg + '">' +
                    '<i class="b-icon"></i>Register | <span>€' + priceReg + '</span>' +
                    '</a>' +
                    '<a href="#" class="tab-list__content-its-my" data-domain="' + key + '" data-priceTrans="' + priceTrans + '"  data-priceRenew="' + priceRenew + '" >' +
                    '<i class="b-icon"></i>It\'s my domain</a>' +
                    '</td></tr>';

            }
            for (key in itemsTop) {
                var status2 = itemsTop[key]['status'];
                var priceReg2 = itemsTop[key]['priceRegister'];
                var priceTrans2 = itemsTop[key]['priceTransfer'];
                var priceRenew2 = itemsTop[key]['priceRenew'];
                var priceOld2 = itemsTop[key]['priceOld'];
                var promo = '';
                if ('promo' in itemsTop[key])
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
                readyTable2 += '<tr class="tab-list__content-table-row tab-list__content-table-row__' + classAv2 + promo + '">' +
                    '<td class="tab-list__content-table-cell">' + key + '</td>' +
                    '<td class="tab-list__content-table-cell">' + status2 + '</td>' +
                    '<td class="tab-list__content-table-cell">' +
                    '<a href="#" class="tab-list__content-reg-this" data-domain="' + key + '" data-price="' + priceReg2 + '">' +
                    '<i class="b-icon"></i>Register | <span>€' + priceReg2 + '</span>' +
                    '</a>' +
                    '<a href="#" class="tab-list__content-its-my" data-domain="' + key + '" data-priceTrans="' + priceTrans2 + '"  data-priceRenew="' + priceRenew2 + '" >' +
                    '<i class="b-icon"></i>It\'s my domain</a>' +
                    '</td></tr>';

            }
            AddData('#result-table tbody', readyTable);
            AddData('#result-table2 tbody', readyTable2);


            bindTableClick();
        });
    }

    $('.domains-step').hide();
    $('#step2').show();
    $('html, body').animate({
        scrollTop: $("#step2").offset().top
    }, 2000);
    return false;
});