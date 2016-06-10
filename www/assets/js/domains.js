var i, a;
var reg = [],
    trans = [];
var summaryPrice = 0;
var searchZones = '';
window.location.hash = '#domains_1';

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

function AddData(target, data) {
    $(target).html(data);
}

function AppendData(target, data) {
    $(target).append(data);
}

String.prototype.stripTags = function () {
    return this.replace(/<\/?[^>]+>/g, '');
};

String.prototype.cutDomain = function () {
    var splitName = this.split('.');
    var cutName = this;
    if (splitName[0].length > 10)
        cutName = splitName[0].substring(0, 10) + '...' + splitName[1];
    return cutName;
};


function AddTransferPopup(container) {
    $(container).append('<div class="transferPopup">' +
        '<span>Перенести и продлить<br/> на 1 год?</span>' +
        '<a href="#" class="transferPopup-yes">Yes</a>' +
        '<a href="#" class="transferPopup-yes">No</a>' +
        '</div>');
}

function bindTableClick() {
    $('.tab-list__content-table-row__available').on('click', 'a.tab-list__content-reg-this', function () {
        var domain = $(this).attr('data-domain');
        var price = $(this).attr('data-price');
        var searchThis = reg.indexOf(domain);
        if (searchThis !== undefined && searchThis != null) {
            if (searchThis < 0) {
                if (!$('#registerSection').is(':visible'))
                    $('#registerSection').addClass('visible_section');
                reg.push(domain);
                $('#domains-register-table tbody').append(
                    '<tr class="domains-step__summary-table-row">' +
                    '<td class="domains-step__summary-table-cell">' + domain + '</td>' +
                    '<td class="domains-step__summary-table-cell">€' + price + '</td>' +
                    '</tr>');
                summaryPrice = parseFloat(summaryPrice) + parseFloat(price);
                $('#Summa').html('€' + summaryPrice);
            }
        }
        return false;
    });
    $('.tab-list__content-table-row__registred').on('click', 'a.tab-list__content-its-my', function () {
        var domain = $(this).attr('data-domain');
        var priceTrans = $(this).attr('data-pricetrans');
        var searchThis = reg.indexOf(domain);
        if (searchThis !== undefined && searchThis != null) {
            if (searchThis < 0) {
                AddTransferPopup(this);
                if (!$('#transferSection').is(':visible'))
                    $('#transferSection').addClass('visible_section');
                reg.push(domain);
                $('#domains-transfer-table tbody').append(
                    '<tr class="domains-step__summary-table-row">' +
                    '<td class="domains-step__summary-table-cell">' + domain + '</td>' +
                    '<td class="domains-step__summary-table-cell">€' + priceTrans + '</td>' +
                    '</tr>');
                summaryPrice = parseFloat(summaryPrice) + parseFloat(priceTrans);
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

$('.search-bar__input').on('keyup', function (e) {
    var svalue = $(this).val().replace(/[^a-zA-Zа-яА-Я0-9-^.]/g, '');
    var nvalue = $(this).val().replace(/[,;!@#$%^&*()_=+/\\'"\[\]\{\}№:?]/g, '\n');
    $(this).val(svalue);
    $(this).val(nvalue);

    if (e.keyCode == 13 && $('input.search-bar__input').is(':visible')) {
        $('.search-bar__button-bulk').click();
        $('.search-bar__input:visible').focus().val($('input.search-bar__input').val());
        $('input.search-bar__input').val('');
    }

});

$('.search-bar__button-bulk').on('click', '', function () {
    $('.search-bar__input').toggleClass('search-bar__input-hidden');
    $('.search-bar__input:visible').val($('.search-bar__input').not(':visible').val());
    $(this).hide();
});

$('.search-bar .b-submit').on('click', '', function () {
    var $checkedInput = $('.hidden-input:checked');

    var readyTable = '';
    var readyTable2 = '';
    var popularTable = '';

    searchZones = '';
    $.each($checkedInput, function () {
        searchZones += $(this).data('name').replace('.', '') + ',';
    });
    searchZones = searchZones.slice(0, -1);

    var searchDomains = '';
    searchDomains = ($('.search-bar__input:visible').val()).replace(/\n/g, ',');
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
                readyTable2 += '<tr class="tab-list__content-table-row tab-list__content-table-row__' + classAv2 + ' ' + promo + '">' +
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

    $('.tab-list__item').on('click', '', function () {
        popularTable = '';
        var thisid = $(this).attr('data-id');
        if (!$('#' + thisid + 'Table').hasClass('notEmpty') && $(this).attr('data-tab') != 1) {
            $.getJSON('/api/v1/shop/domains/check/groups?domainList=' + searchDomains + '&group=' + thisid + '&pg=1', function (data) {
                var items = data['Content'];
                var classAv = '';
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
                    popularTable += '<tr class="tab-list__content-table-row tab-list__content-table-row__' + classAv + '">' +
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
                $('#' + thisid + 'Table').addClass('notEmpty');
                AddData('#' + thisid + 'Table tbody', popularTable);
                bindTableClick();
            });
        }
    });

    window.location.hash = '#domains_2';
    $('html, body').animate({
        scrollTop: $("#step2").offset().top
    }, 2000);
    return false;
});

$('#buy').on('click', '', function () {
    if (reg.length) {
        var summaryRegData = '';
        for (key in reg) {
            summaryRegData += '<tr class="tab-list__content-table-row">' +
                '<td class="tab-list__content-table-cell" title="' + reg[key] + '">' + reg[key].cutDomain() + '</td>' +
                '<td class="tab-list__content-table-cell"><select class="table-select__item js-select" name="tbl-select-' + key + '" id="domains-register-period-select' + key + '" data_preset="' + key + '"><option value="0">1 year / €7</option><option value="1">2 year / €12</option><option value="2">3 year / €20</option></select></td>' +
                '<td class="tab-list__content-table-cell"><div class="bullit-item"><input type="checkbox" class="bullit-item-checkbox" id="bullit-item' + key + '"/><label for="bullit-item' + key + '"></label></div></td>' +
                '<td class="tab-list__content-table-cell"><div class="bullit-item"><input type="checkbox" class="bullit-item-checkbox" id="bullit-item' + key + '1"/><label for="bullit-item' + key + '1"></label></div></td>' +
                '</tr>';
        }
        window.location.hash = '#domains_3';
        AddData('#summaryRegTable tbody', summaryRegData);
        $('.js-select').select2();
    } else if (trans.length) {
        var summaryTransData = '';
        for (key in trans) {
            summaryTransData += '<tr class="tab-list__content-table-row">' +
                '<td class="tab-list__content-table-cell" title="' + trans[key] + '">' + trans[key].cutDomain() + '</td>' +
                '<td class="tab-list__content-table-cell"><select class="table-select__item js-select" name="tbl-select-' + key + '" id="domains-register-period-select' + key + '1" data_preset="' + key + '1"><option value="0">1 year / €7</option><option value="1">2 year / €12</option><option value="2">3 year / €20</option></select></td>' +
                '<td class="tab-list__content-table-cell"><div class="bullit-item"><input type="checkbox" class="bullit-item-checkbox" id="bullit-item' + key + '2"/><label for="bullit-item' + key + '2"></label></div></td>' +
                '<td class="tab-list__content-table-cell"><div class="bullit-item"><input type="checkbox" class="bullit-item-checkbox" id="bullit-item' + key + '3"/><label for="bullit-item' + key + '3"></label></div></td>' +
                '</tr>';
        }
        window.location.hash = '#domains_3';
        AddData('#summaryRegTable tbody', summaryTransData);
    }
    return false;
});

$('.tab-list__content-reg-help:after, .tab-list__content-table-cell').tooltip();