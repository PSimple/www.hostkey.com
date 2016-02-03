<!-- Внимание! Этот файл используется исключительно для локальной разработки -->
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">

        <meta name="viewport" content="width=1280" />

        <LINK REL="SHORTCUT ICON" href="favicon.gif">

        <meta name="format-detection" content="telephone=no">

        <title>Hostkey. Dedicated. Select service</title>

        <link href="assets/css/style.css" rel="stylesheet" type="text/css" media="all">
        <link href="assets/dist/hostkey.css" rel="stylesheet" type="text/css" media="all">

        <!--[if lt IE 9]>
            <script src="js/html5.js"></script>
            <script src="js/css3-mediaqueries.js"></script>
        <![endif]-->

    </head>
    <body ng-app="dedicated.service" class="fade" ng-class="bodyClass()">

        <?php include_once "partials/include.header.php" ?>

        <script>
            window.type = 'dedicated';
            window.country = 'NL';
            window.currency = 'eur';
            window.currencyId = 2;
            window.pid = 448;
        </script>

        <div class="b-page">

            <div class="b-page__promo b-page__promo_dedicated-select-service_yes">
                <h1 class="b-page__promo-title">dedicated</h1>
            </div>

            <div class="b-dedicated">

                <h3 class="b-dedicated__title">
                    DEDICATED<br>
                    FEATURE
                </h3>

                <div class="b-dedicated__feature b-container">
                    <div class="b-dedicated__feature-item">
                        <img class="b-dedicated__feature-item-icon" src="images/dedicate-select-icon-1.png" alt="иконка">
                        <h3 class="b-dedicated__feature-item-title">
                            Tier 3 Data Centers
                        </h3>
                        <p class="b-dedicated__feature-item-text">
                            Only the best secure premises with reliable power and fastest roots to EU, US and Asia for
                            your hardware.
                        </p>
                    </div><!--
                    --><div class="b-dedicated__feature-item">
                        <img class="b-dedicated__feature-item-icon" src="images/dedicate-select-icon-2.png" alt="иконка">
                        <h3 class="b-dedicated__feature-item-title">
                            Servers to be sure of
                        </h3>
                        <p class="b-dedicated__feature-item-text">
                            Always the most reliable
                            hardware from industry learders.
                            Full remote control through IP-KVM (IPMI) on each server.
                        </p>
                    </div><!--
                    --><div class="b-dedicated__feature-item">
                        <img class="b-dedicated__feature-item-icon" src="images/dedicate-select-icon-3.png" alt="иконка">
                        <h3 class="b-dedicated__feature-item-title">
                            Fast service 24/7
                        </h3>
                        <p class="b-dedicated__feature-item-text">
                            Rapid Hardware replacement. Instant delivery of stock
                        </p>
                    </div><!--
                    --><div class="b-dedicated__feature-item">
                        <img class="b-dedicated__feature-item-icon" src="images/dedicate-select-icon-4.png" alt="иконка">
                        <h3 class="b-dedicated__feature-item-title">
                            No-nonsense
                            affordability
                        </h3>
                        <p class="b-dedicated__feature-item-text">
                            VAT free for International
                            customers. Flat traffic rates.
                            No minimum period & setup fee. Save on value rates. All major
                            payment systems accepted.
                        </p>
                    </div>
                </div>

                <div ui-view="solutions"></div>

                    <div class="b-dedicated__switch js-switch-box">
                        <div class="b-dedicated__switch-item js-switch-item active">netherland</div>
                        <div class="b-dedicated__switch-item">/</div>
                        <div class="b-dedicated__switch-item js-switch-item">russia</div>
                    </div>
                </div>

                <!-- Строится с помощью AJAX -->
                <div class="b-dedicated__hide-block js-setting">

                </div>

                <div class="b-dedicated__box">
                    <h3 class="b-dedicated__title b-dedicated__title_upline_yes">
                        features
                    </h3>

                </div>

                <div class="b-container">
                    <div class="b-dedicated-features">
                        <table class="b-dedicated-features__table">
                            <tr class="b-dedicated-features__row">
                                <td class="b-dedicated-features__cell">
                                    <div class="b-dedicated-features__item">
                                        <img class="b-dedicated-features__item-image" src="images/dedicate-features-icons-1.png" alt="иконка"/>
                                        <div class="b-dedicated-features__item-description">
                                            <h3 class="b-dedicated-features__item-title">Network equipment</h3>
                                            <p class="b-dedicated-features__item-text">For complex projects we are
                                                leasing network equipment.
                                                Our network engineers will help you to configure and make
                                                it operational. </p>
                                            <a class="b-dedicated-features__item-link" href="#">more<span class="b-icon b-dedicated-features__item-link-icon"></span></a>
                                        </div>
                                    </div>
                                </td>
                                <td class="b-dedicated-features__cell">
                                    <div class="b-dedicated-features__item">
                                        <img class="b-dedicated-features__item-image" src="images/dedicate-features-icons-2.png" alt="иконка"/>
                                        <div class="b-dedicated-features__item-description">
                                            <h3 class="b-dedicated-features__item-title">USB flash / USB key / USB flash drive</h3>
                                            <p class="b-dedicated-features__item-text">We can connect a USB drive that can be used for backup
                                                or booting server’s OS/Hypervisor.  Clients’ own USB drives are delivered to the Data Center via HOSTKEY or directly by a courier.</p>
                                            <a class="b-dedicated-features__item-link" href="#">more<span class="b-icon b-dedicated-features__item-link-icon"></span></a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr class="b-dedicated-features__row">
                                <td class="b-dedicated-features__cell">
                                    <div class="b-dedicated-features__item">
                                        <img class="b-dedicated-features__item-image" src="images/dedicate-features-icons-3.png" alt="иконка"/>
                                        <div class="b-dedicated-features__item-description">
                                            <h3 class="b-dedicated-features__item-title">Technical support</h3>
                                            <p class="b-dedicated-features__item-text">HOSTKEY provides around the clock support to its clients. To contact our technical support, please, send an email to support@hostkey.com indicating the Service ID </p>
                                            <a class="b-dedicated-features__item-link" href="#">more<span class="b-icon b-dedicated-features__item-link-icon"></span></a>
                                        </div>
                                    </div>
                                </td>
                                <td class="b-dedicated-features__cell">
                                    <div class="b-dedicated-features__item">
                                        <img class="b-dedicated-features__item-image" src="images/dedicate-features-icons-4.png" alt="иконка"/>
                                        <div class="b-dedicated-features__item-description">
                                            <h3 class="b-dedicated-features__item-title">BGP services and clients’own IP-block announcement</h3>
                                            <p class="b-dedicated-features__item-text">HOSKEY can announce client IPv4 networks via its own equipment without using a separate BGP speaker.</p>
                                            <a class="b-dedicated-features__item-link" href="#">more<span class="b-icon b-dedicated-features__item-link-icon"></span></a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr class="b-dedicated-features__row">
                                <td class="b-dedicated-features__cell">
                                    <div class="b-dedicated-features__item">
                                        <img class="b-dedicated-features__item-image" src="images/dedicate-features-icons-5.png" alt="иконка"/>
                                        <div class="b-dedicated-features__item-description">
                                            <h3 class="b-dedicated-features__item-title">BGP services using client’s AS</h3>
                                            <p class="b-dedicated-features__item-text">We are offering flexible options to customers with their own AS to announce IP address prefixes via our equipment through BPG.
                                                We will establish the necessary BGP sessions and will ensure the proper distribution of IP block prefixes from the client’s AS.</p>
                                            <a class="b-dedicated-features__item-link" href="#">more<span class="b-icon b-dedicated-features__item-link-icon"></span></a>
                                        </div>
                                    </div>
                                </td>
                                <td class="b-dedicated-features__cell">
                                    <div class="b-dedicated-features__item">
                                        <img class="b-dedicated-features__item-image" src="images/dedicate-features-icons-6.png" alt="иконка"/>
                                        <div class="b-dedicated-features__item-description">
                                            <h3 class="b-dedicated-features__item-title">IPv4 addresses</h3>
                                            <p class="b-dedicated-features__item-text">We are leasing IP blocks up to 512 addresses in Russia and the Netherlands. Blocks can be routed via VLAN to the client’s server.
                                                It is possible to use the IP addresses on various servers rented from us.</p>
                                            <a class="b-dedicated-features__item-link" href="#">more<span class="b-icon b-dedicated-features__item-link-icon"></span></a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr class="b-dedicated-features__row">
                                <td class="b-dedicated-features__cell">
                                    <div class="b-dedicated-features__item">
                                        <img class="b-dedicated-features__item-image" src="images/dedicate-features-icons-7.png" alt="иконка"/>
                                        <div class="b-dedicated-features__item-description">
                                            <h3 class="b-dedicated-features__item-title">IPv6 addresses</h3>
                                            <p class="b-dedicated-features__item-text">We fully support IPv6 on all of our platforms. If you would like to order IPv6 /64 block of IP addresses, please contact HOSTKEY technical support.IPv6 addresses are allocated free of charge.</p>
                                            <a class="b-dedicated-features__item-link" href="#">more<span class="b-icon b-dedicated-features__item-link-icon"></span></a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="b-dedicated__free">
                    <a class="b-dedicated__free-title" href="#">free<br>
                        test<br>
                        drive
                    </a>
                    <div class="b-dedicated__free-period">30 day free trial </div>
                    <a class="b-submit b-dedicated__free-submit" href="#">see plans</a>
                </div>

                <div class="black-sale">

                    <h2 class="black-sale__title">2014 SALE</h2>

                    <?php include_once "partials/include.black.sale.slider.php" ?>
                </div>

            </div>

            <div class="footer-push"></div>
        </div>

        <?php include_once "partials/include.footer.php" ?>

        <script src="js/jquery-1.11.1.min.js"></script>

        <script src="vendors/jquery-ui-1.11.4/jquery-ui.min.js"></script>

        <script src="js/interface.js"></script>

        <!-- TimerJS -->
        <link  href="vendors/timer/timeTo.css" rel="stylesheet">
        <script src="vendors/timer/jquery.timeTo.min.js"></script>
        <script src="js/timeTo-run.js"></script>

        <!-- SlickJS -->
        <link  href="vendors/slick/slick.css" rel="stylesheet">
        <script src="vendors/slick/slick.min.js"></script>
        <script src="js/slick-run.js"></script>


        <?php include_once "partials/include.all.script.php" ?>

        <script src="assets/dist/hostkey.js"></script>

    </body>
</html>