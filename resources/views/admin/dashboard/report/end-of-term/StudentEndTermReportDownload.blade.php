<!DOCTYPE html>
<html lang="en">
<head>

    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html">
    <meta name="robots" content="noindex, nofollow">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Mobile Specific -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Page Title -->
     <title id="page_title">End of Term Report</title>

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
        body{
            font-size: 8pt;
        }
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
        #tableGrading{
            text-align: center;
        }
        #tableGrading table{
            border: 1px solid gray
        }
        #tableGrading thead{
            border: 1px solid gray
        }
        #tableGrading tbody td{
            border: 1px solid gray
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
                    {{-- {{ dd($data) }} --}}
                    <table  style="width: 100%; align-self: center; font-size=">
                        <tr>
                            <td style="text-align: center">
                                <img style="text-align: right" src="{{public_path($data['schoolProfile'])}}" class='rounded-circle' width=55>
                            </td>
                            <td style="text-align: center">
                                <p class="text-center fw-bolder text-danger" style="text-align: center; color:orangered; font-size: large;">
                                    <b>{{$data['schoolData']['school_name']}}</b>
                                </p>
                                <p class="text-center" style="text-align: center; font-size: 9pt;">
                                    {{$data['schoolData']['school_location']}}
                                </p>
                                <p class="text-center" style="text-align: center; font-size: 9pt;">
                                    {{$data['schoolData']['school_email'] . ' / '.$data['schoolData']['school_phoneNumber']}}
                                </p>
                                <p class="text-center text-info" style="text-align: center; font-size: 9pt; color: red;">
                                    {{$data['studentData']['branch']['branch_name']}} Branch
                                </p>
                            </td>
                            <td style="text-align: center">
                                <img src="{{public_path($data['schoolProfile'])}}" class='rounded-circle' width=55>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <p style="text-align: center; text-transform: uppercase; font-size: 8pt">
                                    Student Assessment Record
                                </p>
                                <p style="text-align: center; text-transform: uppercase; font-size: 9pt; color:orangered;">
                                    <b>End of Term {{$data['termData']['term_name']}} Performance Summary</b>
                                </p>
                            </td>
                        </tr>
                    </table>
                    <hr style="border-top:2px dashed orangered; border-bottom:2px dashed orangered;
                    border-right:0; border-left:0; padding: 1px">
                    <table style="width: 100%; text-align: center">
                        <tr style="text-align: center;">
                            <td style="text-align: left;">
                                Student ID: {{$data['studentData']['student_id']}}
                            </td>
                            <td style="text-align: left;">
                                Student Name: {{$data['studentData']['student_firstname'] . ' ' . $data['studentData']['student_othername'] . ' ' . $data['studentData']['student_lastname']}}
                            </td>
                            <td style="text-align: left;">
                                Level: {{$data['levelData']['level_name']}}
                            </td>
                        </tr>
                        <tr style="text-align: center;">
                            <td style="text-align: left;">
                                Residency: {{$data['studentData']['student_residency_type']}}
                            </td>
                            <td style="text-align: left;">
                                House: {{$data['studentData']['house']['house_name']}}
                            </td>
                            <td style="text-align: left;">
                                Category: {{$data['studentData']['category']['category_name']}}
                            </td>
                        </tr>
                        <tr style="text-align: center;">
                            <td style="text-align: left;">
                                Term: {{$data['termData']['term_name']}}
                            </td>
                            <td style="text-align: left;">
                                Academic Year: {{$data['termData']['academic_year']['academic_year_start'] .'/'.$data['termData']['academic_year']['academic_year_end']}}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <table class="table" style="width: 100%">
                                    <tr>
                                        <td>
                                            Total Class Score: {{$data['classPercentageScore']}}
                                        </td>
                                        <td>
                                            Total Mid-Term Score: {{$data['midTermSummary']['total_percentage']}}
                                        </td>
                                        <td>
                                            Total Exam Score: {{$data['endTermFirst']['total_percentage']}}
                                        </td>
                                        <td>
                                            Total Score: {{$data['endTermFirst']['total_percentage'] + $data['midTermSummary']['total_percentage'] + $data['classPercentageScore']}}
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    <p style="text-transform: uppercase; text-align:center;">
                        <b><u><i>Details of Result</i></u></b>
                    </p>
                    <table style="width: 100%; border: 1px solid black">
                        <tr style="text-align: center; border: 1px solid black">
                            <th style="border-right: 1px solid black">
                                Subject
                            </th>
                            <th style="border-right: 1px solid black">
                                Class Score ({{ $data['schoolAssessmentPercentage']->class_percentage }}%)
                            </th>
                            <th style="border-right: 1px solid black">
                                Mid-Term Score ({{ $data['schoolAssessmentPercentage']->mid_term_percentage }}%)
                            </th>
                            <th style="border-right: 1px solid black">
                                Exam Score ({{ $data['schoolAssessmentPercentage']->exam_percentage }}%)
                            </th>
                            <th style="border-right: 1px solid black">
                                Total Score ({{ $data['schoolAssessmentPercentage']->exam_percentage + $data['schoolAssessmentPercentage']->mid_term_percentage + $data['schoolAssessmentPercentage']->class_percentage }}%)
                            </th>
                            <th style="border-right: 1px solid black">
                                Grade
                            </th>
                            <th>Proficiency Level</th>
                        </tr>
                        @foreach($data['finalData'] as $key => $value)
                            <tr style="text-align: center;">
                                <td style="border: 1px solid black; padding-left:10px">
                                    {{ $value['subject_name'] }}
                                </td>
                                <td style="border: 1px solid black; padding-left:10px">
                                    {{ $value['class_assessment'] ?? 0 }}
                                </td>
                                <td style="border: 1px solid black; padding-left:10px">
                                    {{ $value['mid_term'] ?? 0}}
                                </td>
                                <td style="border: 1px solid black; padding-left:10px">
                                    {{ $value['end_term'] ?? 0}}
                                </td>
                                <td style="text-align: center; border: 1px solid black;">
                                    {{ $value['total'] ?? 0}}
                                </td>
                                <td style="text-align: center; border: 1px solid black;">
                                    {{ $value['grade'] }}
                                </td>
                                <td style="text-align: center; border: 1px solid black;">
                                    {{ $value['level'] }}
                                </td>
                            </tr>
                        @endforeach
                    </table>
                    <table class="table" style="width: 100%">
                        <tr>
                            <td>
                                <p style="text-transform: uppercase;">
                                    <b><u><i>Appraisal </i></u></b>
                                </p>
                                <table class="table"  id="tableAppraisal" style="width: 100%">
                                    <tr>
                                        <td>
                                            Conduct: <b>{{$data['endTermFirst']['conduct']}}</b>
                                        </td>
                                        <td>
                                            Attitude: <b>{{$data['endTermFirst']['attitude']}}</b>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Interest: <b>{{$data['endTermFirst']['interest']}}</b>
                                        </td>
                                        <td>
                                            General Remarks: <b>{{$data['endTermFirst']['general_remarks']}}</b>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                <p style="text-transform: uppercase; text-align:center;">
                                    <b><u><i>Grading System </i></u></b>
                                </p>
                                <table class="table table-striped" style="width: 100%" id="tableGrading">
                                    <thead>
                                        <th>Score</th>
                                        <th>Grade</th>
                                        <th>Proficiency</th>
                                    </thead>
                                    <tbody>
                                        @foreach($data['gradingSystem'] as $key => $grading)
                                            <tr>
                                                <td><span class="fw-bolder">{{ $grading['score_from'].' - '.$grading['score_to']}}</span></td>
                                                <td><span class="fw-bolder">{{ $grading['grade']}}</span></td>
                                                <td><span class="fw-bolder">{{ $grading['level_of_proficiency']}}</span></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </td>
                        </tr>

                    </table>
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
