@extends('layouts.dash-layout')

@push('title')
    <title>Categories | School Mgt Sys</title>
@endpush

@push('page_name')
    <div class="dashboard_bar" id="dash_page_name">
        Categories
    </div>
@endpush

@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <x-dash.dash-term :term_name="$schoolTerm['term_name']"
                              :term_academic_year="$schoolTerm['term_academic_year']"/>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <a class="btn btn-rounded btn-primary" data-bs-toggle="modal"
                               data-bs-target="#new-category-modal">
                                <span class="btn-icon-start text-primary">
                                    <i class="fa fa-plus color-primary"></i>
                                </span> New Category
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="CategoriesDataTables" class="display" style="min-width: 845px">
                                    <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    {{--Modals--}}
    @push('modals')
        @include('admin/dashboard/category/CategoriesModals')
    @endpush
@endsection
{{--page js script--}}
@push('page-js')
    @include('admin/dashboard/category/categoriesJS')
@endpush
{{--page datatable script--}}
@push('datatable')
    @include('admin/dashboard/category/categoriesDataTables')
@endpush
