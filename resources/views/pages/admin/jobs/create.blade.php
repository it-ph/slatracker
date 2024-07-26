@extends('layouts.master')

@section('title') Add Job @endsection

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
        @slot('li_1') Job @endslot
        @slot('title') Add Job @endslot
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
                    <form id="adhocForm" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row mb-3">
                                    <input type="hidden" name="edit_id" id="edit_id">
                                    <label for="name" class="col-sm-3 col-form-label"><strong>Job Name <span class="important">*</span></strong></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="name" id="name" placeholder="Enter Job Name">
                                        <label id="nameError" class="error" style="display:none" style="display:none"></label>
                                    </div>
                                </div>

                                <div class="form-group row mb-3">
                                    <label for="site_id" class="col-sm-3 col-form-label"><strong>Site ID <span class="important">*</span></strong></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="site_id" id="site_id" placeholder="Enter Site ID">
                                        <label id="site_idError" class="error" style="display:none"></label>
                                    </div>
                                </div>

                                <div class="form-group row mb-3">
                                    <label for="platform" class="col-sm-3 col-form-label"><strong>Platform <span class="important">*</span></strong></label>
                                    <div class="col-sm-9">
                                        <select class="form-control select2" name="platform" id="platform"  style="width:100%;">
                                            <option value=""disabled selected>-- Select Platform -- </option>
                                            <option value="Duda" >Duda</option>
                                            <option value="Wordpress" >Wordpress</option>
                                        </select>
                                        <label id="platformError" class="error" style="display:none" style="display:none"></label>
                                    </div>
                                </div>

                                <div class="form-group row mb-3">
                                    <label for="developer_id" class="col-sm-3 col-form-label"><strong>Developer <span class="important">*</span></strong></label>
                                    <div class="col-sm-9">
                                        <select class="form-control select2" name="developer_id" id="developer_id"  style="width:100%;">
                                            <option value=""disabled selected>-- Select Developer -- </option>
                                            <option value="Active" >Active</option>
                                            <option value="Inactive" >Inactive</option>
                                        </select>
                                        <label id="developer_idError" class="error" style="display:none" style="display:none"></label>
                                    </div>
                                </div>

                                <div class="form-group row mb-3">
                                    <label for="request_type" class="col-sm-3 col-form-label"><strong>Type of Request <span class="important">*</span></strong></label>
                                    <div class="col-sm-9">
                                        <select class="form-control select2" name="request_type" id="request_type"  style="width:100%;">
                                            <option value=""disabled selected>-- Select Request Type -- </option>
                                            <option value="Active" >Active</option>
                                            <option value="Inactive" >Inactive</option>
                                        </select>
                                        <label id="request_typeError" class="error" style="display:none" style="display:none"></label>
                                    </div>
                                </div>

                                <div class="form-group row mb-3">
                                    <label for="num_pages" class="col-sm-3 col-form-label"><strong>Num Pages <span class="important">*</span></strong></label>
                                    <div class="col-sm-9">
                                        <select class="form-control select2" name="num_pages" id="num_pages"  style="width:100%;">
                                            <option value=""disabled selected>-- Select Num Pages -- </option>
                                            <option value="Active" >Active</option>
                                            <option value="Inactive" >Inactive</option>
                                        </select>
                                        <label id="num_pagesError" class="error" style="display:none" style="display:none"></label>
                                    </div>
                                </div>

                                <div class="form-group row mb-2">
                                    <label for="salesforce_link" class="col-sm-3 col-form-label"><strong>Salesforce Link <span class="important">*</span></strong></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="salesforce_link" id="salesforce_link" placeholder="Enter Salesforce Link">
                                        <label id="salesforce_linkError" class="error" style="display:none"></label>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="special_request" class="col-sm-3 col-form-label"><strong>Special Request <span class="important">*</span></strong></label>
                                    <div class="col-sm-9">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1">
                                            <label class="form-check-label" for="inlineRadio1">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2">
                                            <label class="form-check-label" for="inlineRadio2">No</label>
                                        </div><br>
                                        <label id="special_requestError" class="error" style="display:none"></label>
                                    </div>
                                </div>

                                <div class="form-group row mb-3">
                                    <label for="comments" class="col-sm-3 col-form-label"><strong>Comments for Special Request <span class="important">*</span></strong></label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control" name="comments" id="comments" cols="30" rows="4" placeholder="Enter comments for special request."></textarea>
                                        <label id="commentsError" class="error" style="display:none"></label>
                                    </div>
                                </div>

                                <div class="form-group row mb-3">
                                    <label for="addon_comments" class="col-sm-3 col-form-label"><strong>Additional Comments <span class="important">*</span></strong></label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control" name="addon_comments" id="addon_comments" cols="30" rows="4" placeholder="Enter additional comments."></textarea>
                                        <label id="addon_commentsError" class="error" style="display:none"></label>
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-12">
                                <div class="form-group float-end">
                                    <button type="submit" id="btn_save" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
                                    <button type="button" id="btn_cancel" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-close"></i> Reset</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div> <!-- end col -->
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
    {{-- <script src="{{asset('scripts/tasklists.js')}}"></script> --}}
@endsection
