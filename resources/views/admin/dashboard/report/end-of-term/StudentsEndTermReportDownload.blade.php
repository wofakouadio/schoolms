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
    <title id="page_title">End of Term Reports</title>

    <!-- Favicon icon -->
    <!-- <link rel="shortcut icon" type="image/png" href="images/favicon.png"> -->

    <!-- Datatable -->
    <link href="{{ asset('assets/vendor/datatables/css/jquery.dataTables.min.css') }}" rel="stylesheet">

    <!-- Material color picker -->
    <link
        href="{{ asset('assets/vendor/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css') }}"
        rel="stylesheet">

    <!-- Pick date -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/pickadate/themes/default.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/pickadate/themes/default.date.css') }}">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!-- All StyleSheet -->
    <link href= "{{ asset('assets/vendor/bootstrap-select/dist/css/bootstrap-select.min.css') }}" rel="stylesheet">
    <link href= "{{ asset('assets/vendor/owl-carousel/owl.carousel.css') }}" rel="stylesheet">

    <!-- sweetalert -->
    <link href= "{{ asset('assets/vendor/sweetalert2/dist/sweetalert2.min.css') }}" rel="stylesheet">

    <!-- Globlal CSS -->
    <link href= "{{ asset('assets/css/style.css') }}" rel="stylesheet">
    <style>
        body {
            font-size: 8pt;
        }

        .page-break {
            page-break-after: always;
        }

        table {
            border-collapse: collapse;
        }

        table tr td {
            padding: 0;
            margin: 0;
        }

        table tr td {
            height: 20px;
        }

        #watermark {
            position: fixed;
            top: 45%;
            width: 100%;
            text-align: center;
            opacity: .6;
            /*transform: rotate(10deg);*/
            transform-origin: 50% 50%;
            z-index: -1000;
        }

        #tableGrading {
            text-align: center;
        }

        #tableGrading table {
            border: 1px solid gray
        }

        #tableGrading thead {
            border: 1px solid gray
        }

        #tableGrading tbody td {
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

                        @foreach ($data as $result)
                            <table class="{{ !$loop->last ? 'page-break' : '' }}"
                                style="width: 100%; align-self: center;">

                                <table style="width: 100%; align-self: center;">
                                    <tr>
                                        <td style="text-align: center">
                                            {{-- <img style="text-align: right" src="{{public_path($data['schoolProfile'])}}" class='rounded-circle' width=55> --}}
                                        </td>
                                        <td style="text-align: center">
                                            <p class="text-center fw-bolder text-danger"
                                                style="text-align: center; color:orangered; font-size: large;">
                                                <b>{{ $schoolData['school_name'] }}</b>
                                            </p>
                                            <p class="text-center" style="text-align: center; font-size: 9pt;">
                                                {{ $schoolData['school_location'] }}
                                            </p>
                                            <p class="text-center" style="text-align: center; font-size: 9pt;">
                                                {{ $schoolData['school_email'] . ' / ' . $schoolData['school_phoneNumber'] }}
                                            </p>
                                            <p class="text-center text-info"
                                                style="text-align: center; font-size: 9pt; color: red;">
                                                {{ $result['branch_name'] }} Branch
                                            </p>
                                        </td>
                                        <td style="text-align: center">
                                            {{-- <img src="{{public_path($data['schoolProfile'])}}" class='rounded-circle' width=55> --}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">
                                            <p style="text-align: center; text-transform: uppercase; font-size: 8pt">
                                                Student Assessment Record
                                            </p>
                                            <p
                                                style="text-align: center; text-transform: uppercase; font-size: 9pt; color:orangered;">
                                                <b>End of Term {{ $termData['term_name'] }} Performance Summary</b>
                                            </p>
                                        </td>
                                    </tr>
                                </table>
                                <hr
                                    style="border-top:2px dashed orangered; border-bottom:2px dashed orangered; border-right:0; border-left:0; padding: 1px">
                                <table style="width: 100%; text-align: center">
                                    <tr style="text-align: center;">
                                        <td style="text-align: left;">
                                            Student ID: {{ $result['student_id'] }}
                                        </td>
                                        <td style="text-align: left;">
                                            Student Name:
                                            {{ $result['student_name'] }}
                                        </td>
                                        <td style="text-align: left;">
                                            Level: {{ $result['level_name'] }}
                                        </td>
                                    </tr>
                                    <tr style="text-align: center;">
                                        <td style="text-align: left;">
                                            Residency: {{ $result['student_residency_type'] }}
                                        </td>
                                        <td style="text-align: left;">
                                            House: {{ $result['house_name'] }}
                                        </td>
                                        <td style="text-align: left;">
                                            Category: {{ $result['category_name'] }}
                                        </td>
                                    </tr>
                                    <tr style="text-align: center;">
                                        <td style="text-align: left;">
                                            Term: {{ $termData['term_name'] }}
                                        </td>
                                        <td style="text-align: left;">
                                            Academic Year:
                                            {{ $termData['academic_year']['academic_year_start'] . '/' . $termData['academic_year']['academic_year_end'] }}
                                        </td>
                                    </tr>



                                    <tr>
                                        <td colspan="3">
                                            <table class="table" style="width: 100%">
                                                <tr>
                                                    <td>
                                                        @php
                                                            $classPercent = 0;
                                                            foreach ($classTotalAssessment as $class) {
                                                                if ($result['student_uuid'] == $class['student_id']) {
                                                                    $classPercent += $class['percentage'];
                                                                } else {
                                                                    $classPercent;
                                                                }
                                                            }
                                                            echo 'Total Class Score: ' . $classPercent;
                                                        @endphp


                                                    </td>
                                                    <td>
                                                        @php
                                                            $midTermPercent = 0;
                                                            foreach ($midTermSummary as $midTerm) {
                                                                if ($result['student_uuid'] == $midTerm['student_id']) {
                                                                    $midTermPercent = $midTerm['total_percentage'];
                                                                } else {
                                                                    $midTermPercent;
                                                                }
                                                            }
                                                            echo 'Total Mid-Term Score: ' . $midTermPercent;
                                                        @endphp
                                                    </td>
                                                    <td>
                                                        @php
                                                            $endTermPercent = 0;
                                                            foreach ($endTermFirst as $endTerm) {
                                                                if ($result['student_uuid'] == $endTerm['student_id']) {
                                                                    $endTermPercent = $endTerm['total_percentage'];
                                                                } else {
                                                                    $endTermPercent;
                                                                }
                                                            }
                                                            echo 'Total End-Term Score: ' . $endTermPercent;
                                                        @endphp
                                                    </td>
                                                    <td>
                                                        @php
                                                            echo 'Total Score : ' .
                                                                $classPercent +
                                                                $midTermPercent +
                                                                $endTermPercent;
                                                        @endphp
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
                                            Class Score ({{ $schoolAssessmentPercentage->class_percentage }}%)
                                        </th>
                                        <th style="border-right: 1px solid black">
                                            Mid-Term Score ({{ $schoolAssessmentPercentage->mid_term_percentage }}%)
                                        </th>
                                        <th style="border-right: 1px solid black">
                                            Exam Score ({{ $schoolAssessmentPercentage->exam_percentage }}%)
                                        </th>
                                        <th style="border-right: 1px solid black">
                                            Total Score
                                            ({{ $schoolAssessmentPercentage->exam_percentage + $schoolAssessmentPercentage->mid_term_percentage + $schoolAssessmentPercentage->class_percentage }}%)
                                        </th>
                                        <th style="border-right: 1px solid black">
                                            Grade
                                        </th>
                                        <th>Proficiency Level</th>
                                    </tr>

                                    @foreach ($result['subjects'] as $value)
                                    <tr style="text-align: center;">
                                        <td style="border: 1px solid black; padding-left:10px">
                                            {{ $value['subject_name'] }}
                                        </td>
                                        <td style="border: 1px solid black; padding-left:10px">
                                            {{ $value['class_score_percentage'] ?? 0 }}
                                        </td>
                                        <td style="border: 1px solid black; padding-left:10px">
                                            {{ $value['mid_term_score_percentage'] ?? 0}}
                                        </td>
                                        <td style="border: 1px solid black; padding-left:10px">
                                            {{ $value['end_term_score_percentage'] ?? 0}}
                                        </td>
                                        <td style="text-align: center; border: 1px solid black;">
                                            {{ $value['total_score'] ?? 0}}
                                        </td>
                                        @foreach($gradingSystem as $key => $gs)
                                            @if($value['total_score'] >= $gs['score_from'] && $value['total_score'] <= $gs['score_to'])
                                                <td style="text-align: center; border: 1px solid black;">
                                                    {{ $gs->grade }}
                                                </td>
                                                <td style="text-align: center; border: 1px solid black;">
                                                    {{ $gs->level_of_proficiency }}
                                                </td>
                                            @endif
                                        @endforeach
                                    </tr>
                                @endforeach
                                </table>
                            </table>
                            <div class="page-break"></div>
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
    <script src="{{ asset('assets/vendor/global/global.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script>

    <!-- Dashboard 1 -->
    <script src="{{ asset('assets/js/dashboard/dashboard-1.js') }}"></script>

    <script src="{{ asset('assets/vendor/owl-carousel/owl.carousel.js') }}"></script>

    <!-- Material color picker -->
    <script src="{{ asset('assets/vendor/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js') }}">
    </script>
    <script src="{{ asset('assets/vendor/bootstrap-datepicker-master/js/bootstrap-datepicker.min.js') }}"></script>

    <!-- pickdate -->
    <script src="{{ asset('assets/vendor/pickadate/picker.js') }}"></script>
    <script src="{{ asset('assets/vendor/pickadate/picker.time.js') }}"></script>
    <script src="{{ asset('assets/vendor/pickadate/picker.date.js') }}"></script>

    <!-- sweetalert -->
    <script src="{{ asset('assets/vendor/sweetalert2/dist/sweetalert2.min.js') }}"></script>

    <!-- Datatable -->
    <script src="{{ asset('assets/vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
    {{-- <script src="{{asset('assets/js/plugins-init/datatables.init.js')}}"></script> --}}

    <script src="{{ asset('assets/js/custom.min.js') }}"></script>
    <script src="{{ asset('assets/js/dlabnav-init.js') }}"></script>
