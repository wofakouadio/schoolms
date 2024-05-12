<!DOCTYPE html>
<html lang="en">
<head>

    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="robots" content="noindex, nofollow">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Mobile Specific -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Page Title -->
     <title id="page_title">Dashboard</title>

    <!-- Favicon icon -->
    <!-- <link rel="shortcut icon" type="image/png" href="images/favicon.png"> -->

    <!-- Datatable -->
    <link href="{{asset('assets/vendor/datatables/css/jquery.dataTables.min.css')}}" rel="stylesheet">

    <!-- Material color picker -->
    <link href="{{asset('assets/vendor/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css')}}" rel="stylesheet">

    <!-- Pick date -->
    <link rel="stylesheet" href="{{asset('assets/vendor/pickadate/themes/default.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/pickadate/themes/default.date.css')}}">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!-- All StyleSheet -->
    <link href= "{{asset('assets/vendor/bootstrap-select/dist/css/bootstrap-select.min.css')}}" rel="stylesheet">
    <link href= "{{asset('assets/vendor/owl-carousel/owl.carousel.css')}}" rel="stylesheet">

    <!-- sweetalert -->
    <link href= "{{asset('assets/vendor/sweetalert2/dist/sweetalert2.min.css')}}" rel="stylesheet">

    <!-- Globlal CSS -->
    <link href= "{{asset('assets/css/style.css')}}" rel="stylesheet">

</head>
<body>

<!--**********************************
    Main wrapper start
***********************************-->
<div id="main-wrapper">
    <!--**********************************
        Content body start
    ***********************************-->
    <div class="content-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mt-3">
                        <div class="card-header"> Invoice <strong>01/01/01/2018</strong> <span class="float-end">
                                    <strong>Status:</strong> Pending</span> </div>
                        <div class="card-body">
                            <div class="row mb-5">
                                <div class="mt-4 col-xl-3 col-lg-3 col-md-6 col-sm-12">
                                    <h6>From:</h6>
                                    <div> <strong>Webz Poland</strong> </div>
                                    <div>Madalinskiego 8</div>
                                    <div>71-101 Szczecin, Poland</div>
                                    <div>Email: info@webz.com.pl</div>
                                    <div>Phone: +48 444 666 3333</div>
                                </div>
                                <div class="mt-4 col-xl-3 col-lg-3 col-md-6 col-sm-12">
                                    <h6>To:</h6>
                                    <div> <strong>Bob Mart</strong> </div>
                                    <div>Attn: Daniel Marek</div>
                                    <div>43-190 Mikolow, Poland</div>
                                    <div>Email: marek@daniel.com</div>
                                    <div>Phone: +48 123 456 789</div>
                                </div>
                                <div class="mt-4 col-xl-6 col-lg-6 col-md-12 col-sm-12 d-flex justify-content-lg-end justify-content-md-center justify-content-xs-start">
                                    <div class="row align-items-center">
                                        <div class="col-sm-9">
                                            <div class="brand-logo mb-3">
                                                <img class="logo-abbr me-2" width="50" src="images/logo.png" alt="">
                                                <!-- <img class="logo-compact" width="110" src="images/logo-text.png" alt=""> -->
                                                <svg class="brand-title" xmlns="http://www.w3.org/2000/svg" width="134.01" height="48.365" viewBox="0 0 134.01 48.365">
                                                    <g id="Group_38" data-name="Group 38" transform="translate(-133.99 -40.635)">
                                                        <text id="Job_Admin_Dashboard" data-name="Job Admin Dashboard" transform="translate(134 85)" fill="#787878" font-size="12" font-family="Poppins-Light, Poppins" font-weight="300"><tspan x="0" y="0">Job Admin Dashboard</tspan></text>
                                                        <path id="Path_1948" data-name="Path 1948" d="M.36,6.616a1.661,1.661,0,0,0,1.094-.422,1.287,1.287,0,0,0,.5-1.016V-11.738H7.52L7.551,5.271A8.16,8.16,0,0,1,6.91,8.789a4.074,4.074,0,0,1-2.2,1.985,11.542,11.542,0,0,1-4.346.657ZM17.651,9.68A7.316,7.316,0,0,1,13.7,8.617a7.008,7.008,0,0,1-2.626-2.97,9.786,9.786,0,0,1-.922-4.315,9.276,9.276,0,0,1,.907-4.174,6.935,6.935,0,0,1,2.6-2.877,7.438,7.438,0,0,1,4-1.047,7.607,7.607,0,0,1,4.018,1.032,6.8,6.8,0,0,1,2.611,2.861,9.349,9.349,0,0,1,.907,4.205,9.759,9.759,0,0,1-.922,4.33,6.993,6.993,0,0,1-2.642,2.955A7.4,7.4,0,0,1,17.651,9.68Zm0-4.565a1.753,1.753,0,0,0,1.438-.954,5.2,5.2,0,0,0,.625-2.83,4.8,4.8,0,0,0-.594-2.626,1.73,1.73,0,0,0-1.47-.907,1.694,1.694,0,0,0-1.454.907,4.908,4.908,0,0,0-.578,2.626,5.309,5.309,0,0,0,.61,2.83A1.718,1.718,0,0,0,17.651,5.115Zm17.478,4.6q-2.345,0-5.972-.375L27.75,9.18V-12.238h5.44V-6.11q.25-.094.844-.3a6.64,6.64,0,0,1,1.079-.281,6.807,6.807,0,0,1,1.079-.078,5.75,5.75,0,0,1,4.737,1.939q1.579,1.939,1.579,6.285,0,4.377-1.767,6.316T35.129,9.711Zm-.594-4.878a2.3,2.3,0,0,0,1.876-.719A4.131,4.131,0,0,0,37,1.551Q37-1.92,34.754-1.92q-.719,0-1.563.063v6.6A10.43,10.43,0,0,0,34.535,4.834ZM45.134-6.36h5.44V9.274h-5.44Zm.031-6.222h5.44V-7.36h-5.44ZM59.611,9.68a5.9,5.9,0,0,1-4.909-2q-1.595-2-1.595-6.222a12.451,12.451,0,0,1,.844-5.143A4.635,4.635,0,0,1,56.3-6.125a9.87,9.87,0,0,1,3.846-.641,13.2,13.2,0,0,1,2.095.188q1.157.188,3.033.625L65.145-1.7q-2.908-.219-3.627-.219a4.459,4.459,0,0,0-1.845.3,1.565,1.565,0,0,0-.844.985,6.976,6.976,0,0,0-.219,2A7.45,7.45,0,0,0,58.845,3.5a1.625,1.625,0,0,0,.86,1.032,4.362,4.362,0,0,0,1.813.3l3.6-.219L65.27,8.9A27.641,27.641,0,0,1,59.611,9.68Zm8.473-21.918h5.44V-.325l1.032-.406L76.714-6.36H82.78L79.4,1.207,83,9.274H76.9L74.744,3.958l-1.219.406V9.274h-5.44Z" transform="translate(133.63 53.217)" fill="#464646"></path>
                                                    </g>
                                                </svg>
                                            </div>
                                            <span>Please send exact amount: <strong class="d-block">0.15050000 BTC</strong>
                                                    <strong>1DonateWffyhwAjskoEwXt83pHZxhLTr8H</strong></span><br>
                                            <small class="text-muted">Current exchange rate 1BTC = $6590 USD</small>
                                        </div>
                                        <div class="col-sm-3 mt-3"> <img src="images/qr.png" alt="" class="img-fluid width110"> </div>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th class="center">#</th>
                                        <th>Item</th>
                                        <th>Description</th>
                                        <th class="right">Unit Cost</th>
                                        <th class="center">Qty</th>
                                        <th class="right">Total</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td class="center">1</td>
                                        <td class="left strong">Origin License</td>
                                        <td class="left">Extended License</td>
                                        <td class="right">$999,00</td>
                                        <td class="center">1</td>
                                        <td class="right">$999,00</td>
                                    </tr>
                                    <tr>
                                        <td class="center">2</td>
                                        <td class="left">Custom Services</td>
                                        <td class="left">Instalation and Customization (cost per hour)</td>
                                        <td class="right">$150,00</td>
                                        <td class="center">20</td>
                                        <td class="right">$3.000,00</td>
                                    </tr>
                                    <tr>
                                        <td class="center">3</td>
                                        <td class="left">Hosting</td>
                                        <td class="left">1 year subcription</td>
                                        <td class="right">$499,00</td>
                                        <td class="center">1</td>
                                        <td class="right">$499,00</td>
                                    </tr>
                                    <tr>
                                        <td class="center">4</td>
                                        <td class="left">Platinum Support</td>
                                        <td class="left">1 year subcription 24/7</td>
                                        <td class="right">$3.999,00</td>
                                        <td class="center">1</td>
                                        <td class="right">$3.999,00</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="row">
                                <div class="col-lg-4 col-sm-5"> </div>
                                <div class="col-lg-4 col-sm-5 ms-auto">
                                    <table class="table table-clear">
                                        <tbody>
                                        <tr>
                                            <td class="left"><strong>Subtotal</strong></td>
                                            <td class="right">$8.497,00</td>
                                        </tr>
                                        <tr>
                                            <td class="left"><strong>Discount (20%)</strong></td>
                                            <td class="right">$1,699,40</td>
                                        </tr>
                                        <tr>
                                            <td class="left"><strong>VAT (10%)</strong></td>
                                            <td class="right">$679,76</td>
                                        </tr>
                                        <tr>
                                            <td class="left"><strong>Total</strong></td>
                                            <td class="right"><strong>$7.477,36</strong><br>
                                                <strong>0.15050000 BTC</strong></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--**********************************
        Content body end
    ***********************************-->



</div>



<!--**********************************
	Scripts
***********************************-->
<!-- Required vendors -->
<script src="{{asset('assets/vendor/global/global.min.js')}}"></script>
<script src="{{asset('assets/vendor/bootstrap-select/dist/js/bootstrap-select.min.js')}}"></script>

<!-- Dashboard 1 -->
<script src="{{asset('assets/js/dashboard/dashboard-1.js')}}"></script>

<script src="{{asset('assets/vendor/owl-carousel/owl.carousel.js')}}"></script>

<!-- Material color picker -->
<script src="{{asset('assets/vendor/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js')}}"></script>
<script src="{{asset('assets/vendor/bootstrap-datepicker-master/js/bootstrap-datepicker.min.js')}}"></script>

<!-- pickdate -->
<script src="{{asset('assets/vendor/pickadate/picker.js')}}"></script>
<script src="{{asset('assets/vendor/pickadate/picker.time.js')}}"></script>
<script src="{{asset('assets/vendor/pickadate/picker.date.js')}}"></script>

<!-- sweetalert -->
<script src="{{asset('assets/vendor/sweetalert2/dist/sweetalert2.min.js')}}"></script>

<!-- Datatable -->
<script src="{{asset('assets/vendor/datatables/js/jquery.dataTables.min.js')}}"></script>
{{--<script src="{{asset('assets/js/plugins-init/datatables.init.js')}}"></script>--}}

<script src="{{asset('assets/js/custom.min.js')}}"></script>
<script src="{{asset('assets/js/dlabnav-init.js')}}"></script>
