<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="col-md-12">
                    <p class="fw-bold mb-1 text-primary">QC Details</p>
                    <table class="table table-bordered table-sm nowrap w-100">
                        <tr>
                            <td class="col-sm-3 fw-bold">Preview Link</td>
                            <td class="col-sm-9">{{ $job['name'] }}</td>
                        </tr>
                        <tr>
                            <td class="col-sm-3 fw-bold">Self QC Performed</td>
                            <td class="col-sm-9">{{ $job['site_id'] }}</td>
                        </tr>
                        <tr>
                            <td class="col-sm-3 fw-bold">Developer Comments</td>
                            <td class="col-sm-9">{{ $job['platform'] }}</td>
                        </tr>
                        <tr>
                            <td class="col-sm-3 fw-bold">QC Round</td>
                            <td class="col-sm-9">{{ $job['platform'] }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
