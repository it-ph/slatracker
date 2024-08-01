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
                <button type="button" class="btn btn-primary btn-sm waves-effect waves-light" title="View Job" onclick="JOB.start({{ $job['id'] }})"><i class="fas fa-play"></i> Start</button>
            @endif
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
                    <form id="addJobForm" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <p class="fw-bold mb-1">Job Details</p>
                                <table class="table table-bordered table-sm nowrap w-100">
                                    <tr>
                                        <td class="col-sm-2 fw-bold">Job Name</td>
                                        <td class="col-sm-10">{{ $job['name'] }}</td>
                                    </tr>
                                    <tr>
                                        <td class="col-sm-2 fw-bold">Site ID</td>
                                        <td class="col-sm-10">{{ $job['site_id'] }}</td>
                                    </tr>
                                    <tr>
                                        <td class="col-sm-2 fw-bold">Platform</td>
                                        <td class="col-sm-10">{{ $job['platform'] }}</td>
                                    </tr>
                                    <tr>
                                        <td class="col-sm-2 fw-bold">Developer</td>
                                        <td class="col-sm-10">{{ $job['developer'] }}</td>
                                    </tr>
                                    <tr>
                                        <td class="col-sm-2 fw-bold">Type of Request</td>
                                        <td class="col-sm-10">{{ $job['request_type'] }}</td>
                                    </tr>
                                    <tr>
                                        <td class="col-sm-2 fw-bold">Num of Pages</td>
                                        <td class="col-sm-10">{{ $job['request_volume'] }}</td>
                                    </tr>
                                    <tr>
                                        <td class="col-sm-2 fw-bold">Salesforce Link</td>
                                        <td class="col-sm-10"><a href="{{ $job['salesforce_link'] }}" target="_blank" class="text-info">{{ $job['salesforce_link'] }}</a></td>
                                    </tr>
                                    <tr>
                                        <td class="col-sm-2 fw-bold">Special Request</td>
                                        <td class="col-sm-10">{{ $job['is_special_request'] }}</td>
                                    </tr>
                                    <tr>
                                        <td class="col-sm-2 fw-bold">Comments for Special Request</td>
                                        <td class="col-sm-10">{{ $job['comments'] }}</td>
                                    </tr>
                                    <tr>
                                        <td class="col-sm-2 fw-bold">Additional Comments</td>
                                        <td class="col-sm-10">{{ $job['addon_comments'] }}</td>
                                    </tr>
                                    <tr>
                                        <td class="col-sm-2 fw-bold">SLA Agreed</td>
                                        <td class="col-sm-10"><span class="badge bg-primary">{{ $job['agreed_sla'] }} hrs</span></td>
                                    </tr>
                                    <tr>
                                        <td class="col-sm-2 fw-bold">SLA Missed</td>
                                        <td class="col-sm-10">@if($job['sla_missed']) <span class="text-danger">Yes</span> @else <span class="text-success">No</span> @endif</td>
                                    </tr>
                                    <tr>
                                        <td class="col-sm-2 fw-bold">Start Time</td>
                                        <td class="col-sm-10">{{ $job['start_at'] }}</td>
                                    </tr>
                                    <tr>
                                        <td class="col-sm-2 fw-bold">End Time</td>
                                        <td class="col-sm-10">{{ $job['end_at'] }}</td>
                                    </tr>
                                </table>
                            </div>
                            {{-- <hr>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <button type="submit" id="btn_save" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
                                    <button type="button" id="btn_cancel" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
                                </div>
                            </div> --}}
                        </div>
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
    <script src="{{ asset('assets/libs/datatables/dataTables.fixedColumns.min.js') }}"></script>
    <script src="{{ asset('assets/libs/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('assets/libs/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/libs/select2/select2.min.js') }}"></script>
    <script src="{{ asset('assets/libs/select2/select2.js') }}"></script>
@endsection

@section('custom-js')
    {{-- <script src="{{asset('scripts/create-job.js')}}"></script> --}}
@endsection
