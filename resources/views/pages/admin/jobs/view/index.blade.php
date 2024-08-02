@extends('layouts.master')

@section('title') View Job @endsection

@section('css')
    <!-- DataTables -->
    <link href="{{ asset('assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/libs/datatables/buttons.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/libs/datatables/fixedColumns.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <style>
        .dataTables_scrollBody thead tr[role="row"]{
            visibility: collapse !important;
        }
    </style>
@endsection

@section('content')

    @component('components.breadcrumb_w_button')
        @slot('li_1') View Job @endslot
        @slot('title') View Job
            @if(auth()->user()->id == $job['developer_id'] && $job['status'] == 'Not Started')
                <button type="button" class="btn btn-primary btn-sm waves-effect waves-light" title="View Job" onclick="JOB.showModal()"><i class="fas fa-play"></i> Start</button>
            @endif
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-md-12">
            @include('notifications.success')
            @include('notifications.error')
        </div>
    </div>

    {{-- view only --}}
    @include('pages.admin.jobs.view.job-details')

    {{-- view w/ start if assigned dev and status Not Started --}}
    @if(auth()->user()->id == $job['developer_id'] && $job['status'] == 'Not Started')
        @include('pages.admin.jobs.view.start-modal')
    @endif

    {{-- view w/ submit details and wherein status In Progress --}}
    @if(auth()->user()->id == $job['developer_id'] && $job['status'] == "In Progress" && $job['dev_comments'] == null)
        @include('pages.admin.jobs.view.submit-details')
    @endif

    {{-- job w/ additional details --}}
    @if(auth()->user()->id == $job['developer_id'] && $job['status'] == "In Progress" && $job['dev_comments'])
        @include('pages.admin.jobs.view.qc-submission')
    @endif

@endsection

@section('script')
    <!-- Required datatable js -->
    <script src="{{ asset('assets/libs/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables/dataTables.fixedColumns.min.js') }}"></script>
    <script src="{{ asset('assets/libs/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('assets/libs/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/libs/select2/select2.min.js') }}"></script>
    <script src="{{ asset('assets/libs/select2/select2.js') }}"></script>
@endsection

@section('custom-js')
    <script src="{{asset('scripts/viewjob.js')}}"></script>
@endsection
