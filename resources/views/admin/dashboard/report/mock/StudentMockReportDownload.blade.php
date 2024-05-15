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
    <style>
        table{
            border-collapse: collapse;
        }
        table tr td{
            padding:0;
            margin: 0;
        }
        table tr td{
            height: 20px;
        }
        #watermark{
            position: fixed;
            top: 45%;
            width: 100%;
            text-align: center;
            opacity: .6;
            /*transform: rotate(10deg);*/
            transform-origin: 50% 50%;
            z-index: -1000;
        }
    </style>
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
{{--                    <div id="watermark">--}}
{{--                        <img src="/public/assets/images/ghana-emblem.jpg">--}}
{{--                    </div>--}}
                    @foreach($data as $value)
                        <table  style="width: 100%; align-self: center;">
                            <tr>
                                <td colspan="3">
                                    <p class="text-center fw-bolder
                                    text-danger" style="text-align: center; color:orangered; font-size: large;
                                    "><b>{{$value['schoolData']['school_name']}}</b></p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3">
                                    <table width="100%" style="text-align: center">
                                        <tr>
                                            <td width="15%" style="text-align: right">
                                                <img style="text-align: right" src="{{public_path($value['schoolProfile'])}}"
                                                     class='rounded-circle' width=55>
                                            </td>
                                            <td width="70%" style="text-align: center; ">
                                                <p class="text-center" style="text-align: center; font-size: 9pt;
                                    ">{{$value['schoolData']['school_location']}}</p>
                                                <p class="text-center" style="text-align: center; font-size: 9pt;
                                    ">{{$value['schoolData']['school_email'] . ' / '.
                                        $value['schoolData']['school_phoneNumber']}}</p>
                                                <p class="text-center
                                    text-info" style="text-align: center; font-size: 9pt; color: red;
                                    ">{{$value['studentData']['branch']['branch_name']}} Branch</p>
                                            </td>
                                            <td width="15%" style="text-align: left">
                                                <img style="text-align: left" src="{{public_path($value['studentProfile'])}}"
                                                     class='rounded-circle'
                                                     width=55 alt="pic">
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3">
                                    <p style="text-align: center; text-transform: uppercase; font-size: 8pt">Student
                                        Assessment Record</p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3">
                                    <p style="text-align: center; text-transform: uppercase; font-size: 9pt; color:orangered;
                                    "><b>Mock {{$value['mockData']['mock_type']}} Performance Summary</b></p>
                                </td>
                            </tr>
                        </table>
                        <hr style="border-top:2px dashed orangered; border-bottom:2px dashed orangered;
                        border-right:0; border-left:0; padding: 1px">
                        <table style="width: 100%; border: 1px solid black; text-align: center">
                            <tr style="text-align: center; border: 1px solid black">
                                <td style="border-right: 1px solid black; text-align: left; padding-left:10px">Student
                                    ID:</td>
                                <td style="border-right: 1px solid black; text-align:
                                left; padding-left:10px">{{$value['studentData']['student_id']}}</td>
                                <td style="border-right: 1px solid black; text-align: left; padding-left:10px">Student
                                    Name:</td>
                                <td style="border-right: 1px solid
                                black; text-align: left; padding-left:10px">{{$value['studentData']['student_firstname']
                                 . '
                                 ' .
                                                $value['studentData']['student_othername'] . ' ' .
                                                $value['studentData']['student_lastname']}}</td>
                            </tr>
                            <tr style="text-align: center; border: 1px solid black">
                                <td style="border-right: 1px solid black; text-align: left; padding-left:10px">Level:</td>
                                <td style="border-right: 1px solid black; text-align: left; padding-left:10px">{{$value['levelData']['level_name']}}</td>
                                <td style="border-right: 1px solid black; text-align: left; padding-left:10px">Residency:</td>
                                <td style="border-right: 1px solid
                                black; text-align: left; padding-left:10px">{{$value['studentData']['student_residency_type']}}</td>
                            </tr>
                            <tr style="text-align: center; border: 1px solid black">
                                <td style="border: 1px solid black; text-align: left;
                                padding-left:10px">House:</td>
                                <td style="border: 1px solid black; text-align: left;
                                padding-left:10px">{{$value['studentData']['house']['house_name']}}</td>
                                <td style="border: 1px solid black; text-align: left;
                                padding-left:10px">Category:</td>
                                <td style="border: 1px solid black; text-align: left;
                                padding-left:10px">{{$value['studentData']['category']['category_name']}}</td>
                            </tr>
                            <tr style="text-align: center; border: 1px solid black">
                                <td style="border: 1px solid black; text-align: left; padding-left:10px">Term:</td>
                                <td style="border: 1px solid black; text-align: left; padding-left:10px">{{$value['termData']['term_name']}}</td>
                                <td style="border: 1px solid black; text-align: left;
                                padding-left:10px">Academic Year:</td>
                                <td style="border: 1px solid black; text-align: left; padding-left:10px">{{$value['termData']['term_academic_year']}}</td>
                            </tr>
                            <tr style="text-align: center; border: 1px solid black">
                                <td style="border: 1px solid black; text-align: left;
                                padding-left:10px">Mock:</td>
                                <td style="border: 1px solid black; text-align: left;
                                padding-left:10px">{{$value['mockData']['mock_type']}}</td>
                                <td style="border: 1px solid black; text-align: left;
                                padding-left:10px">Total Score:</td>
                                <td style="border: 1px solid black; text-align: left; padding-left:10px">{{$value['mockFirstEntry']['total_score']}}</td>
                            </tr>
                        </table>
                        <p style="text-transform: uppercase; text-align:center;"><b><u><i>Details of
                                        Result</i></u></b></p>
                        <table style="width: 100%; border: 1px solid black">
                            <tr style="text-align: center; border: 1px solid black">
                                <th style="border-right: 1px solid black">Subject</th>
                                <th style="border-right: 1px solid black">Score</th>
                                <th>Proficiency Level</th>
                            </tr>
                            @foreach($value['mockBreakdown'] as $breakdown)
                                <tr>
                                    <td style="border: 1px solid black; padding-left:10px">
                                        {{$breakdown['subject']['subject_name']}}
                                    </td>
                                    <td style="text-align: center; border: 1px solid black;">
                                        {{$breakdown['score']}}
                                    </td>
                                    <td style="text-align: center; border: 1px solid black;">
                                        -
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                        <p style="text-transform: uppercase; text-align:center;"><b><u><i>Appraisal </i></u></b></p>
                        <table style="width: 100%; border: 1px solid black;"
                               cellspacing="0" cellpadding="0">
                            <tr style="border: 1px solid black">
                                <td style="border: 1px solid black; padding-left:10px"><b>Conduct</b></td>
                                <td style="border: 1px solid black;
                                padding-left:10px;">{{$value['mockFirstEntry']['conduct']}}</td>
                                <td style="border: 1px solid black; padding-left:10px"><b>Attitude</b></td>
                                <td style="border: 1px solid black;
                                padding-left:10px">{{$value['mockFirstEntry']['attitude']}}</td>
                            </tr>
                            <tr style="border: 1px solid black">
                                <td style="border: 1px solid black; padding-left:10px"><b>Interest</b></td>
                                <td style="border: 1px solid black;
                                padding-left:10px">{{$value['mockFirstEntry']['interest']}}</td>
                                <td style="border: 1px solid black; padding-left:10px"><b>General Remarks</b></td>
                                <td style="border: 1px solid black; padding-left:10px
                                ">{{$value['mockFirstEntry']['general_remarks']}}</td>
                            </tr>
                        </table>
                    @endforeach
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
