@extends('layouts.master')

@section('title') Email Configuration @endsection

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

    @component('components.breadcrumb')
        @slot('li_1') Manage @endslot
        @slot('title') Email Configuration @endslot
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
                    <form id="configsForm" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row mb-2">
                                    <input type="hidden" name="edit_id" id="edit_id" value="{{ $email_config['id'] }}">
                                    {{-- <label for="name" class="col-sm-3 col-form-label"><strong>Client Name <span class="important">*</span></strong></label> --}}
                                    <div class="col-sm-9">
                                        <input type="hidden" class="form-control" name="name" id="name" placeholder="Enter Client Name">
                                        <label id="nameError" class="error" style="display:none"></label>
                                    </div>
                                </div>
                                <div class="form-group row mb-2">
                                    <label for="sla_threshold" class="col-sm-3 col-form-label"><strong>SLA Threshold for Email Notifs (%) <span class="important">*</span></strong></label>
                                    <div class="col-sm-9">
                                        <input type="number" class="form-control" name="sla_threshold" id="sla_threshold" min="0" max="100" placeholder="Enter SLA Threshold E.g 70">
                                        <label id="sla_thresholdError" class="error" style="display:none"></label>
                                    </div>
                                </div>

                                <div class="form-group row mb-2">
                                    <label for="sla_threshold_to" class="col-sm-3 col-form-label"><strong>SLA Threshold Cross Email Recipients (TO) <span class="important">*</span></strong></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="sla_threshold_to" id="sla_threshold_to" placeholder="Enter SLA Threshold Cross Email Recipients (TO)">
                                        <label id="sla_threshold_toError" class="error" style="display:none"></label>
                                    </div>
                                </div>

                                <div class="form-group row mb-2">
                                    <label for="sla_threshold_cc" class="col-sm-3 col-form-label"><strong>SLA Threshold Cross Email Recipients (CC) <span class="important">*</span></strong></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="sla_threshold_cc" id="sla_threshold_cc" placeholder="Enter SLA Threshold Cross Email Recipients (CC)">
                                        <label id="sla_threshold_ccError" class="error" style="display:none"></label>
                                    </div>
                                </div>

                                <div class="form-group row mb-2">
                                    <label for="sla_missed_to" class="col-sm-3 col-form-label"><strong>SLA Missed Email Recipients (TO) <span class="important">*</span></strong></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="sla_missed_to" id="sla_missed_to" placeholder="Enter SLA Missed Email Recipients (TO)">
                                        <label id="sla_missed_toError" class="error" style="display:none"></label>
                                    </div>
                                </div>

                                <div class="form-group row mb-2">
                                    <label for="sla_missed_cc" class="col-sm-3 col-form-label"><strong>SLA Missed Email Recipients (CC) <span class="important">*</span></strong></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="sla_missed_cc" id="sla_missed_cc" placeholder="Enter SLA Missed Email Recipients (CC)">
                                        <label id="sla_missed_ccError" class="error" style="display:none"></label>
                                    </div>
                                </div>

                                <div class="form-group row mb-2">
                                    <label for="new_job_cc" class="col-sm-3 col-form-label"><strong>New Job Email Recipients (CC) <span class="important">*</span></strong></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="new_job_cc" id="new_job_cc" placeholder="Enter New Job Email Recipients (CC)">
                                        <label id="new_job_ccError" class="error" style="display:none"></label>
                                    </div>
                                </div>

                                <div class="form-group row mb-2">
                                    <label for="qc_send_cc" class="col-sm-3 col-form-label"><strong>QC Send Email Recipients (CC) <span class="important">*</span></strong></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="qc_send_cc" id="qc_send_cc" placeholder="Enter SLA Missed Email Recipients (CC)">
                                        <label id="qc_send_ccError" class="error" style="display:none"></label>
                                    </div>
                                </div>

                                <div class="form-group row mb-2">
                                    <label for="daily_report_to" class="col-sm-3 col-form-label"><strong>Daily Report Recipients (TO) <span class="important">*</span></strong></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="daily_report_to" id="daily_report_to" placeholder="Enter Daily Report Recipients (TO)">
                                        <label id="daily_report_toError" class="error" style="display:none"></label>
                                    </div>
                                </div>

                                <div class="form-group row mb-2">
                                    <label for="daily_report_cc" class="col-sm-3 col-form-label"><strong>Daily Report Recipients (CC) <span class="important">*</span></strong></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="daily_report_cc" id="daily_report_cc" placeholder="Enter Daily Report Recipients (CC)">
                                        <label id="daily_report_ccError" class="error" style="display:none"></label>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <button type="submit" id="btn_save" class="btn btn-primary"><i class="fa fa-save"></i> Update</button>
                                    <button type="button" id="btn_cancel" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
                                </div>
                            </div>
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
    <script src="{{asset('scripts/email-configs.js')}}"></script>
@endsection
