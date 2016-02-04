<!-- Внимание! Этот файл используется исключительно для локальной разработки -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <!-- Layout Second Page -->
    <meta name="viewport" content="width=1280"/>

    <LINK REL="SHORTCUT ICON" href="/assets/img/favicon.gif">

    <meta name="format-detection" content="telephone=no">

    <title>Discounted prices for servers in Russia and the Netherlands| by HOSTKEY</title>
    <meta name="keywords" content="Sale dedicated servers"/>
    <meta name="description"
          content="Ready to use servers, we just need to install the required OS. A choice of Data Centers."/>

    <link href="/assets/css/style.css" rel="stylesheet" type="text/css" media="all">
    <link href="/assets/dist/hostkey.css" rel="stylesheet" type="text/css" media="all">

    <!--[if lt IE 9]>
    <script src="/assets/js/html5.js"></script>
    <script src="/assets/js/css3-mediaqueries.js"></script>
    <![endif]-->

    <script src="/assets/js/jquery-1.11.1.min.js"></script>
    <script src="/assets/vendors/jquery-ui-1.11.4/jquery-ui.min.js"></script>
    <script src="/assets/js/interface.js"></script>
    <script src="/assets/vendors/checkbox/fake-checkbox.js"></script>
    <script src="/assets/js/scroll-block.js"></script>

    <!-- TimerJS -->
    <link href="/assets/vendors/timer/timeTo.css" rel="stylesheet">
    <script src="/assets/vendors/timer/jquery.timeTo.min.js"></script>
    <!--<script src="/assets/js/timeTo-run.js"></script>-->

    <!-- arcticModal -->
    <script src="/assets/vendors/arcticmodal/jquery.arcticmodal-0.3.min.js"></script>
    <link rel="stylesheet" href="/assets/vendors/arcticmodal/jquery.arcticmodal-0.3.css">

    <!-- arcticModal theme -->
    <link rel="stylesheet" href="/assets/vendors/arcticmodal/themes/simple.css">

    <style>
        .b-page__promo_text-page_yes {
            background: url(http://site-f.hostke.ru/upload/data/section/100/100/100/100/100/100/100/100/100/100/99/promo_about.png) no-repeat;
            height: 600px;
        }
    </style>

    <script>
        window.country = 'NL';
        window.currency = 'eur';
    </script>

</head>
<body ng-app="app.dedicated.sale" class="fade" ng-class="bodyClass()">

    <?php include_once "partials/include.header.php" ?>

    <div class="b-page">

        <div class="b-page__promo b-page__promo_dedicated-select-service_yes">
            <div class="b-icon b-page__scroll-icon" onclick="$.scrollTo('#scroll-anchor-01', 1000, { offset:-90 })"></div>
            <h1 class="b-page__promo-title">SaleNL</h1>
        </div>

        <div class="b-text-page" ui-view=""></div>

        <div class="footer-push"></div>
    </div>

    <style type="text/css">
        .table_stan {
            border-spacing: 0;
            /*border: 1px solid red;*/
            border-bottom: 1px solid #945ae0;
            background: #fffff;
            border-collapse: separate;
            text-align: left;
            border-radius: 10px;
            border-bottom-right-radius: 0;
            border-bottom-left-radius: 0;
        }

        .table_stan th {
            background: #945ae0;
            color: white;
            padding: 15px 15px;
            text-align: center;
            /* border-left: 1px solid #945ae0; */
            border-left: none;
            border-top: 1px solid #945ae0;
            /*border-top: none;*/
        }

        .table_stan tr:nth-child(odd) {
            background: #e9ebee;
        }

        .table_stan td {
            padding: 15px 15px;
            transition: all 0.5s ease;
            /*border-left: 1px solid #fff;*/
            border-left: none;
            border-top: 1px solid #945ae0;
        }

        .table_stan td:first-child, .table_stan th:first-child {
            border-left: none;
        }

        .table_stan th:first-child {
            border-top-left-radius: 10px;
        }

        .table_stan th:last-child {
            border-top-right-radius: 10px;
        }

        /*
    .table_stan tr:last-child {
            border-bottom: 1px solid #945ae0;
        }*/
    </style>


    <footer class="b-footer">

        <div class="b-footer__contacts">
            <div class="b-footer__contacts-description">
                Please, write & call.<br/>
                We will answer all your questions
            </div>
            <p class="b-footer__contacts-text">
                <span class="b-icon b-footer__contacts-text-icon b-footer__contacts-text-icon_1"></span>+31 20 820 3777 </p>

            <p class="b-footer__contacts-text b-footer__contacts-text_red_yes">
                <span class="b-icon b-footer__contacts-text-icon b-footer__contacts-text-icon_2"
                      style="margin-right: -4px;"></span>
                <a href="mailto:sales@hostkey.com" title="sales@hostkey.com">sales@hostkey.com</a>
            </p>

            <p class="b-footer__contacts-text">
                <span class="b-icon b-footer__contacts-text-icon b-footer__contacts-text-icon_3"></span>Tussen de Bogen 6,
                Amsterdam, the Netherlands </p>
        </div>
        <div class="b-footer__wrapper">
            <div class="b-footer__dev">
                <p class="b-footer__text">© 2007-2016, HOSTKEY B.V., All Rights Reserved</p>

                <p class="b-footer__text">MADE BY <a class="b-link b-footer__link" href="#">SUNERA</a></p>
            </div>
            <div class="b-icon b-footer__triangle" onclick="$.scrollTo(0, 1000)"></div>
        </div>

    </footer>

    <!-- SlickJS -->
    <link href="/assets/vendors/slick/slick.css" rel="stylesheet">
    <script src="/assets/vendors/slick/slick.min.js"></script>
    <script src="/assets/js/slick-run.js"></script>
    <script src="/assets/dist/hostkey.js"></script>
    <script src="/assets/js/jquery.cookie.js"></script>
    <script src="/assets/vendors/jquery.scrollTo-1.4.13/jquery.scrollTo.min.js"></script>

    <script src="/assets/vendors/checkbox/fake-checkbox.js"></script>

    <link href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css" rel="stylesheet"/>
    <script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>

    <link rel="stylesheet" href="/assets/vendors/colorbox/colorbox.css"/>
    <script src="/assets/vendors/colorbox/jquery.colorbox-min.js"></script>

</body>
</html>