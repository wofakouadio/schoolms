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
     <title id="page_title"> Arrears Statement</title>

    <!-- Favicon icon -->
    <!-- <link rel="shortcut icon" type="image/png" href="images/favicon.png"> -->

    <!-- Datatable -->
    {{-- <link href="{{asset('assets/vendor/datatables/css/jquery.dataTables.min.css')}}" rel="stylesheet"> --}}

    <!-- Material color picker -->
    {{-- <link href="{{asset('assets/vendor/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css')}}" rel="stylesheet"> --}}

    <!-- Pick date -->
    {{-- <link rel="stylesheet" href="{{asset('assets/vendor/pickadate/themes/default.css')}}"> --}}
    {{-- <link rel="stylesheet" href="{{asset('assets/vendor/pickadate/themes/default.date.css')}}"> --}}
    {{-- <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"> --}}

    <!-- All StyleSheet -->
    {{-- <link href= "{{asset('assets/vendor/bootstrap-select/dist/css/bootstrap-select.min.css')}}" rel="stylesheet"> --}}
    {{-- <link href= "{{asset('assets/vendor/owl-carousel/owl.carousel.css')}}" rel="stylesheet"> --}}

    <!-- sweetalert -->
    {{-- <link href= "{{asset('assets/vendor/sweetalert2/dist/sweetalert2.min.css')}}" rel="stylesheet"> --}}

    <!-- Globlal CSS -->
    {{-- <link href= "{{asset('assets/css/style.css')}}" rel="stylesheet"> --}}
    <style>
        table{
            width: 100%;
            border-collapse: collapse;
            page-break-inside: avoid;
        }
        table tr td{
            padding:0;
            margin: 0;
        }

        table tr td p{
            text-align: center;
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
        #innerTable{
            font-size: 10pt;
            text-align: center;
        }
        #innerTable tr{
            border: 1px solid gray
        }
        #innerTable td{
            border: 1px solid gray
        }
        #innerTable th{
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
                    <table class="table" style="width:100%">
                        <tr>
                            <td colspan="2">
                                {{-- <img src="{{ asset('assets/images/ghana-emblem.jpg') }}"  class='rounded' width="200"/> --}}
                                </td>
                            <td colspan="2">
                                <p>{{ $schoolData->school_name}}</p>
                                <p>{{ $schoolData->school_location }}</p>
                                <p>{{ $schoolData->school_email }}</p>
                                <p>{{ $schoolData->school_phoneNumber }}</p>
                            </td>
                            <td colspan="2">
                                {{-- <img src="{{ public_path($schoolPhoto) }}" class='rounded' width="200"/> --}}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="6"></td>
                        </tr>
                        <tr>
                            <td colspan="2">Student ID: <b>{{ $student->student_id }}</b></td>
                            <td colspan="2">Name: <b>{{ $student->student_firstname . ' ' . $student->student_othername . ' ' . $student->student_lastname }}</b></td>
                            <td colspan="2">Level / Class: <b>{{ $student->level->level_name }}</b></td>
                        </tr>
                        <tr>
                            <td colspan="2">House: <b>{{ $student->house->house_name }}</b></td>
                            <td colspan="2">Category: <b>{{ $student->category->category_name }}</b></td>
                            <td colspan="2">Branch: <b>{{ $student->branch->branch_name }}</b></td>
                        </tr>
                        <tr>
                            <td colspan="6"></td>
                        </tr>
                        <tr>
                            <td colspan="6">
                                <table class="table" id="innerTable">
                                    <tr>
                                        <th>#</th>
                                        <th>Invoice #</th>
                                        <th>Level</th>
                                        <th>Term</th>
                                        <th>Acad. Year</th>
                                        <th>Description</th>
                                        <th>Due</th>
                                        <th>Paid</th>
                                        <th>Balance</th>
                                        <th>Transac. Type</th>
                                        <th>Status</th>
                                        <th>Paid Date</th>
                                        <th>Reference</th>
                                    </tr>
                                    {{-- {{ dd($records) }} --}}
                                    @foreach ($arrears_records as $record)
                                        <tr>
                                            <td><p style="color: black;">{{ $loop->iteration }}</p></td>
                                            <td>{{ $record->invoice_id }}</td>
                                            <td>{{ $record->level->level_name }}</td>
                                            <td>{{ $record->term->term_name }}</td>
                                            <td>{{ $record->academic_year->academic_year_start .'/'. $record->academic_year->academic_year_end}}</td>
                                            <td>{{ $record->description }}</td>
                                            <td>{{ $record->currency.' '.$record->amount_due }}</td>
                                            <td>{{ $record->currency.' '.$record->amount_paid }}</td>
                                            <td>{{ $record->currency.' '.$record->balance }}</td>
                                            <td>{{ $record->transaction_type ?? 'N/A' }}</td>
                                            <td>{{ $record->payment_statement ?? 'N/A' }}</td>
                                            <td>{{ $record->paid_at ?? 'N/A' }}</td>
                                            <td>{{ $record->reference ?? 'N/A' }}</td>
                                        </tr>
                                    @endforeach
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
{{-- <script src="{{asset('assets/vendor/global/global.min.js')}}"></script> --}}
{{-- <script src="{{asset('assets/vendor/bootstrap-select/dist/js/bootstrap-select.min.js')}}"></script>

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

{{-- <script src="{{asset('assets/js/custom.min.js')}}"></script>
<script src="{{asset('assets/js/dlabnav-init.js')}}"></script> --}}
