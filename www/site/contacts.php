<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">

        <meta name="viewport" content="width=1280" />

        <LINK REL="SHORTCUT ICON" href="favicon.gif">

        <meta name="format-detection" content="telephone=no">

        <title>Hostkey. Contacts</title>

        <link href="stylesheets/style.css" rel="stylesheet" type="text/css" media="all">

        <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true"></script>
        <script type="text/javascript" src="http://www.google.com/jsapi"></script>

        <!--[if lt IE 9]>
            <script src="js/html5.js"></script>
            <script src="js/css3-mediaqueries.js"></script>
        <![endif]-->

    </head>
    <body>

        <?php include_once "partials/include.header.php" ?>

        <div class="b-page b-page_contacts-page_yes">

            <div class="b-page__promo b-page__promo_faq_yes">
                <h1 class="b-page__promo-title">Contacts</h1>
            </div>

            <div class="b-contacts">

                <div class="b-container">
                    <div class="b-contacts__text">
                        Technical Support
                    </div>
                    <p class="b-contacts__text b-contacts__text_inline_yes">
                        <span class="b-icon b-contacts__text-icon b-contacts__text-icon_1"></span>Phone / fax: +7 (916) 479 73 41
                    </p>
                    <p class="b-contacts__text b-contacts__text_inline_yes b-contacts__text_red_yes">
                        <span class="b-icon b-contacts__text-icon b-contacts__text-icon_2"></span>support@hostkey.ru
                    </p>
                </div>

                <div class="b-contacts__list js-tab-wrapper">
                    <div class="b-contacts__switch">
                        <div class="b-container">
                            <div class="b-contacts__title current js-add-map js-tab" data-pos-x="55.783485" data-pos-y="37.709158" data-tab="1">
                                <span class="b-icon b-contacts__title-icon"></span>
                                Central office
                            </div>
                            <div class="b-contacts__title js-add-map js-tab" data-pos-x="55.697631" data-pos-y="37.565654" data-tab="2">
                                <span class="b-icon b-contacts__title-icon"></span>
                                data centers in Russia
                            </div>
                            <div class="b-contacts__title js-add-map js-tab" data-pos-x="52.543666" data-pos-y="5.70521" data-tab="3">
                                <span class="b-icon b-contacts__title-icon"></span>
                                data centers in netherlands
                            </div>
                        </div>
                    </div>

                    <div class="b-contacts__item js-tab-content current" data-tab="1">
                        <div class="b-container">
                            <div class="b-contacts__description">
                                The technical services of the data center are available 7 days a week and 24 hours a day.<br>
                                Please, confirm 24h prior to your visit.
                            </div>
                            <div class="b-contacts__description">ADDRESS:</div>
                            <a class="b-contacts__item-map js-map" href="#">
                                <div class=" js-add-map" data-pos-x="55.783485" data-pos-y="37.709158">
                                    <div class="b-contacts__item-link">
                                        <span class="b-icon b-contacts__item-icon"></span>
                                        Barabanniy per, 4/4, Moscow, Russia
                                    </div>
                                </div>
                            </a>
                             <a class="b-contacts__item-map js-map" href="#">
                                <div class=" js-add-map" data-pos-x="52.3835427" data-pos-y="4.8882864">
                                    <div class="b-contacts__item-link">
                                        <span class="b-icon b-contacts__item-icon"></span>
                                        Tussen de Bogen 6, 1013JB Amsteram
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="b-contacts__item js-tab-content" data-tab="2">
                        <div class="b-container">
                            <div class="b-contacts__description">
                                The technical services of the data center are available 7 days a week and 24 hours a day.<br>
                                Please, confirm 24h prior to your visit.
                            </div>
                            <div class="b-contacts__description">ADDRESS:</div>
                            <a class="b-contacts__item-map js-map" href="#">
                                <div class=" js-add-map" data-pos-x="55.697631" data-pos-y="37.565654">
                                    <div class="b-contacts__item-link">
                                        <span class="b-icon b-contacts__item-icon"></span>
                                        Leninskiy prospekt 53, 119333 Moscow
                                    </div>
                                </div>
                            </a>
                            <a class="b-contacts__item-map js-map" href="#">
                                <div class=" js-add-map" data-pos-x="55.736262" data-pos-y="37.721089">
                                    <div class="b-contacts__item-link">
                                        <span class="b-icon b-contacts__item-icon"></span>
                                        Aviamotornaya Str 69, 111024 Moscow
                                    </div>
                                </div>
                            </a>
                            <a class="b-contacts__item-map js-map" href="#">
                                <div class=" js-add-map" data-pos-x="55.8858983" data-pos-y="37.5147407">
                                    <div class="b-contacts__item-link">
                                        <span class="b-icon b-contacts__item-icon"></span>
                                        Korovinskoe shosse, 41, 125 412 Moscow
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="b-contacts__item js-tab-content" data-tab="3">
                        <div class="b-container">
                            <div class="b-contacts__description">
                                The technical services of the data center are available 7 days a week and 24 hours a day.<br>
                                Please, confirm 24h prior to your visit.
                            </div>
                            <div class="b-contacts__description">ADDRESS:</div>
                            <a class="b-contacts__item-map js-map" href="#">
                                <div class=" js-add-map" data-pos-x="52.543666" data-pos-y="5.70521">
                                    <div class="b-contacts__item-link">
                                        <span class="b-icon b-contacts__item-icon"></span>
                                         De Linge 26,  8253PJ Dronten
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>





                <div class="map-canvas-wrapper"><div id="map-canvas" class="map-canvas"></div></div>

            </div>

            <div class="footer-push footer-push_contacts-page_yes"></div>
        </div>



        <?php include_once "partials/include.footer.contacts.php" ?>

        <script src="js/jquery-1.11.1.min.js"></script>

        <script src="js/interface.js"></script>
        <script src="js/initMap.js"></script>

        <?php include_once "partials/include.all.script.php" ?>



    </body>
</html>