<!DOCTYPE html>
<html lang="en">
<head>

    <!-- Meta -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="robots" content="noindex, nofollow">
    <meta name="csrf-token" content="{{ csrf_token() }}">

	<!-- Mobile Specific -->
	<meta name="viewport" content="width=device-width, initial-scale=0.75">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

	<!-- Page Title -->
	{{-- <title id="page_title">Dashboard</title> --}}
    @stack('title')

	<!-- Favicon icon -->
	<!-- <link rel="shortcut icon" type="image/png" href="images/favicon.png"> -->

	<!-- Datatable -->
    {{-- <link href="{{asset('assets/vendor/datatables/css/jquery.dataTables.min.css')}}" rel="stylesheet"> --}}
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">

    {{-- select 2 --}}
    {{-- <link rel="stylesheet" href="{{ asset('assets/vendor/select2/css/select2.min.css') }}"> --}}
    <link href="{{ asset('assets/vendor/select2/css/select2.min.css') }}" rel="stylesheet">

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
		/* body{
			zoom: 85%;
		} */
	</style>

</head>
<body>
