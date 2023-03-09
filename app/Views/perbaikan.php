<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="Description" content="Bootstrap Responsive Admin Web Dashboard HTML5 Template">
    <meta name="Author" content="Spruko Technologies Private Limited">
    <meta name="Keywords" content="admin,admin dashboard,admin dashboard template,admin panel template,admin template,admin theme,bootstrap 4 admin template,bootstrap 4 dashboard,bootstrap admin,bootstrap admin dashboard,bootstrap admin panel,bootstrap admin template,bootstrap admin theme,bootstrap dashboard,bootstrap form template,bootstrap panel,bootstrap ui kit,dashboard bootstrap 4,dashboard design,dashboard html,dashboard template,dashboard ui kit,envato templates,flat ui,html,html and css templates,html dashboard template,html5,jquery html,premium,premium quality,sidebar bootstrap 4,template admin bootstrap 4" />

    <!-- Title -->
    <title> Valex - Premium dashboard ui bootstrap rwd admin html5 template </title>

    <!--- Favicon --->
    <link rel="icon" href="<?= base_url() ?>/assets/img/ft.png" type="image/x-icon" />

    <!--- Icons css --->
    <link href="<?= base_url() ?>/assets/css/icons.css" rel="stylesheet">

    <!-- Bootstrap css -->
    <link href="<?= base_url() ?>/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!--- Right-sidemenu css --->
    <link href="<?= base_url() ?>/assets/plugins/sidebar/sidebar.css" rel="stylesheet">

    <!-- P-scroll bar css-->
    <link href="<?= base_url() ?>/assets/plugins/perfect-scrollbar/p-scrollbar.css" rel="stylesheet" />

    <!--- Style css --->
    <link href="<?= base_url() ?>/assets/css/style.css" rel="stylesheet">

    <!--- Skinmodes css --->
    <link href="<?= base_url() ?>/assets/css/skin-modes.css" rel="stylesheet">
    <link href="<?= base_url() ?>/assets/css/boxed.css" rel="stylesheet">
    <link href="<?= base_url() ?>/assets/css/dark-boxed.css" rel="stylesheet">

    <!--- Darktheme css --->
    <link href="<?= base_url() ?>/assets/css/style-dark.css" rel="stylesheet">

    <!--- Animations css --->
    <link href="<?= base_url() ?>/assets/css/animate.css" rel="stylesheet">

</head>

<body class="error-page1 main-body">



    <!-- Loader -->
    <div id="global-loader">
        <img src="<?= base_url() ?>/assets/img/loader.svg" class="loader-img" alt="Loader">
    </div>
    <!-- /Loader -->

    <!-- Page -->
    <div class="page">

        <div class="container-fluid">
            <div class="row no-gutter">
                <!-- The image half -->
                <div class="col-md-5 col-lg-6 col-xl-7 d-none d-md-flex bg-primary-transparent">
                    <div class="row wd-100p mx-auto text-center">
                        <div class="col-md-12 col-lg-12 col-xl-12 my-auto mx-auto wd-100p">
                            <img src="<?= base_url() ?>/assets/img/media/underconstruction.png" class="my-auto ht-xl-80p wd-md-100p wd-xl-80p mx-auto" alt="logo">
                        </div>
                    </div>
                </div>
                <!-- The content half -->
                <div class="col-md-7 col-lg-6 col-xl-5 bg-white">
                    <div class="login d-flex align-items-center py-2">
                        <!-- Demo content-->
                        <div class="container">
                            <div class="row">
                                <div class="main-card-signin construction text-center border-0 mx-auto">
                                    <div class="p-4 wd-100p mx-auto">
                                        <div>
                                            <h2 class="tx-30">Mohon Maaf Dalam Perbaikan</h2>
                                            <p class="tx-12 text-muted">Kami Sedang Melakukan Update dan Maintenance. Silahkan Kembali Lagi Nanti</p>
                                            <div class="row row-sm mx-auto">
                                                <div id="count-down" class="center-block mt-3 mb-3 mx-auto">
                                                    <div class="clock-presenter days_dash">
                                                        <div class="digit"></div>
                                                        <div class="digit"></div>
                                                        <p class="mt-2">Days</p>
                                                    </div>
                                                    <div class="clock-presenter hours_dash">
                                                        <div class="digit"></div>
                                                        <div class="digit"></div>
                                                        <p class="mt-2">Hours</p>
                                                    </div>
                                                    <div class="clock-presenter minutes_dash">
                                                        <div class="digit"></div>
                                                        <div class="digit"></div>
                                                        <p class="mt-2">Minutes</p>
                                                    </div>
                                                    <div class="clock-presenter seconds_dash me-0">
                                                        <div class="digit"></div>
                                                        <div class="digit"></div>
                                                        <p class="mt-2">Seconds</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!-- End -->
                    </div>
                </div><!-- End -->
            </div>
        </div>

    </div>
    <!-- End Page -->

    <!--- JQuery min js --->
    <script src="<?= base_url() ?>/assets/plugins/jquery/jquery.min.js"></script>

    <!--- Bootstrap Bundle js --->
    <script src="<?= base_url() ?>/assets/plugins/bootstrap/js/popper.min.js"></script>
    <script src="<?= base_url() ?>/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!--- Ionicons js --->
    <script src="<?= base_url() ?>/assets/plugins/ionicons/ionicons.js"></script>

    <!--- JQuery sparkline js --->
    <script src="<?= base_url() ?>/assets/plugins/jquery-sparkline/jquery.sparkline.min.js"></script>


    <!--- Moment js --->
    <script src="<?= base_url() ?>/assets/plugins/moment/moment.js"></script>

    <!-- P-scroll js -->
    <script src="<?= base_url() ?>/assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>

    <!--- Eva-icons js --->
    <script src="<?= base_url() ?>/assets/js/eva-icons.min.js"></script>

    <!--- Jquery.Coutdown js --->
    <script src="<?= base_url() ?>/assets/plugins/jquery-countdown/jquery.lwtCountdown-1.0.js"></script>
    <!-- <script src="<?= base_url() ?>/assets/plugins/jquery-countdown/count-down.js"></script> -->
    <script>
        $(function() {
            "use strict";
            // Set your date
            $('#count-down').countDown({
                targetDate: {
                    'day': 21,
                    'month': 3,
                    'year': 2023,
                    'hour': 0,
                    'min': 0,
                    'sec': 0
                },
                omitWeeks: true
            });

        });
    </script>


    <!--- Rating js --->
    <script src="<?= base_url() ?>/assets/plugins/rating/jquery.rating-stars.js"></script>
    <script src="<?= base_url() ?>/assets/plugins/rating/jquery.barrating.js"></script>

    <!--- Custom js --->
    <script src="<?= base_url() ?>/assets/js/custom.js"></script>

</body>

</html>