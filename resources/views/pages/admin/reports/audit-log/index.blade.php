@extends('layouts.master')

@section('title') Reports @endsection

@section('css')
    <!-- DataTables -->
    <link href="{{ asset('assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/libs/datatables/buttons.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/daterangepicker/daterangepicker.css') }}" />
    <link href="{{ asset('assets/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1') Reports @endslot
        @slot('title') Audit Logs @endslot
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
                                    <label for="daterange"><strong>Date Range</strong></label>
                                    <input class="form-control input-daterange-datepicker" type="text" name="daterange" value="{{\Carbon\Carbon::now()->subDays(7)->format('m-d-Y')}} - {{date('m-d-Y')}}">
                                </div>
                                <div class="col-md-3 mb-2">
                                    <label for="request_type_id"><strong>Request Type</strong></label>
                                    <select class="form-control select2" name="request_type_id" id="request_type_id"  style="width:100%;">
                                        <option value="all" selected>All</option>
                                            @foreach ($request_types as $request_type)
                                                @if($request_type)
                                                    <option value="{{ $request_type->id }}">{{ ucwords($request_type->name) }}</option>
                                                @endif
                                            @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3 mb-2">
                                    <label for="auditor_id"><strong>Auditor</strong></label>
                                    <select class="form-control select2" name="auditor_id" id="auditor_id"  style="width:100%;">
                                        <option value="all" selected>All</option>
                                            @foreach ($auditors as $auditor)
                                                <option value="{{ $auditor->id }}">{{ ucwords($auditor->username) }}</option>
                                            @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3 mb-2">
                                    <label for="email"><strong>Status</strong></label>
                                    <select class="form-control select2" name="" id="filtered_to" style="width:100%;" required>
                                        <option value="all" selected>All</option>
                                        <option value="Not Started">Not Started</option>
                                        <option value="In Progress">In Progress</option>
                                        <option value="Quality Check">Quality Check</option>
                                        <option value="Bounced Back">Bounced Back</option>
                                        <option value="Closed">Closed</option>
                                    </select>
                                </div>
                        </div>
                        <button type="submit" data-toggle="tooltip" title="Click to Download Report" class="btn btn-primary btn-sm"> <strong> <i class="fa fa-search"></i> Search</strong></button>
                        <button type="submit" data-toggle="tooltip" title="Click to Download Report" class="btn btn-secondary btn-sm"> <strong> <i class="fa fa-refresh"></i> Reset</strong></button>
                        <button type="submit" data-toggle="tooltip" title="Click to Download Report" class="btn btn-success btn-sm"> <strong> <i class="fa fa-download"></i> Export</strong></button>
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
    <script src="{{ asset('assets/plugins/moment/moment.min.js')}}"></script>
    <script src="{{ asset('assets/plugins/daterangepicker/daterangepicker.min.js')}}"></script>
    <script src="{{ asset('assets/libs/select2/select2.min.js') }}"></script>
    <script src="{{ asset('assets/libs/select2/select2.js') }}"></script>
@endsection

@section('custom-js')
    {{-- <script src="{{asset('scripts/myjobs.js')}}"></script> --}}
    <script>
        $('.input-daterange-datepicker').daterangepicker({
            buttonClasses: ['btn', 'btn-sm'],
            applyClass: 'btn-primary',
            cancelClass: 'btn-danger'
        });
    </script>
@endsection
