@extends('layouts.master')

@section('title') Pending Jobs @endsection

@section('css')
    <!-- DataTables -->
    <link href="{{ asset('assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/libs/datatables/buttons.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')

    @component('components.breadcrumb_w_button')
        @slot('li_1') Job @endslot
        @slot('title') Pending Jobs
            <button type="button" class="btn btn-primary btn-sm waves-effect waves-light" title="View Job" onclick="JOB.showModal()"> View Workload</button>
        @endslot
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
                    <table id="tbl_jobs" class="table table-bordered table-striped table-sm nowrap w-100">
                        <thead>
                            <tr>
                                <th class="text-center">Job Name</th>
                                <th class="text-center">Type of Request</th>
                                <th class="text-center">Num Pages</th>
                                <th class="text-center">Special Request</th>
                                <th class="text-center">Created On</th>
                                <th class="text-center">Start Time</th>
                                <th class="text-center">Agreed SLA</th>
                                <th class="text-center">Time Elapsed</th>
                                <th class="text-center">SLA Missed</th>
                                <th class="text-center">Potential SLA Miss</th>
                                <th class="text-center">Developer</th>
                                <th class="text-center">Status</th>
                            </tr>
                        </thead>
                    </table>
                    <div id="div-spinner" class="text-center mt-4 mb-4">
                        <span id="loader" style="font-size: 16px"><i class="fa fa-spinner fa-spin"></i> Please wait...</span>
                    </div>
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
@endsection

@section('custom-js')
    <script src="{{asset('scripts/pendingjobs.js')}}"></script>
@endsection
