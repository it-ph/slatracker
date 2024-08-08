@extends('layouts.master')

@section('title') Reports @endsection

@section('css')
    <!-- DataTables -->
    <link href="{{ asset('assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/libs/datatables/buttons.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/libs/daterangepicker/daterangepicker.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1') Reports @endslot
        @slot('title') Development Report @endslot
    @endcomponent

    <div class="row">
        <div class="col-md-12">
            @include('notifications.success')
            @include('notifications.error')
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    {{-- <form action="{{ route('export') }}" method="POST"> --}}
                    <form action="" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-3 mb-2">
                                <label for="datefilter"><strong>Date Range</strong></label>
                                <div id="datefilter" class="form-control datefilter">
                                    <span></span>
                                </div>
                                <input type="hidden" class="form-control" name="daterange" id="daterange">
                            </div>
                            <div class="col-md-3 mb-2">
                                <label for="platform"><strong>Platform</strong></label>
                                <select class="form-control select2" name="platform" id="platform"  style="width:100%;">
                                    <option value="all" selected>All</option>
                                    <option value="Duda">Duda</option>
                                    <option value="Wordpress">Wordpress</option>
                                </select>
                            </div>
                        </div>
                        <button type="submit" data-toggle="tooltip" title="Click to Download Report" class="btn btn-primary btn-sm"> <strong> <i class="fa fa-paper-plane"></i> Send Email</strong></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <!-- Required datatable js -->
    <script src="{{ asset('assets/libs/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/libs/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('assets/libs/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/libs/select2/select2.min.js') }}"></script>
    <script src="{{ asset('assets/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('assets/libs/daterangepicker/moment.min.js') }}"></script>
    <script src="{{ asset('assets/libs/daterangepicker/daterangepicker.min.js') }}"></script>
@endsection

@section('custom-js')
    {{-- <script src="{{asset('scripts/myjobs.js')}}"></script> --}}
    <script src="{{asset('scripts/daterangepicker.init.js')}}"></script>
@endsection
