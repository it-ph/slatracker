@extends('layouts.master')

@section('title') Users @endsection

@section('css')
    <!-- DataTables -->
    <link href="{{ asset('assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/libs/datatables/buttons.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')

    @component('components.breadcrumb_w_button')
        @slot('li_1') Manage / Users @endslot
        @slot('title') Users
            <button type="button" class="btn btn-primary btn-sm waves-effect waves-light" onclick="USER.showModal()"><i class="fas fa-plus"></i> Create</button>
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
                    <table id="tbl_users" class="table table-bordered table-striped table-sm nowrap w-100">
                        <thead>
                            <tr>
                                <th>FullName</th>
                                <th>Email Address</th>
                                <th>Client</th>
                                <th>Role</th>
                                <th>Last Login Time</th>
                                <th class="text-center">Status</th>
                                <th width="5%" class="text-center">Action</th>
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

    @include('pages.admin.users.user-modal')
@endsection

@section('script')
    <!-- Required datatable js -->
    <script src="{{ asset('assets/libs/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/libs/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('assets/libs/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/libs/select2/select2.min.js') }}"></script>
    <script src="{{ asset('assets/libs/select2/select2.js') }}"></script>
@endsection

@section('custom-js')
    <script src="{{asset('scripts/users.js')}}"></script>
@endsection


