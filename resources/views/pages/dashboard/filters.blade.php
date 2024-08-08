<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
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
                            <label for="developer_id"><strong>Developer</strong></label>
                            <select class="form-control select2" name="developer_id" id="developer_id"  style="width:100%;">
                                <option value="all" selected>All</option>
                                    @foreach ($developers as $developer)
                                        <option value="{{ $developer->id }}">{{ ucwords($developer->username) }}</option>
                                    @endforeach
                            </select>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
