<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="col-md-12">
                    <p class="fw-bold mb-1 text-primary">Job Details</p>
                    <table class="table table-bordered table-sm nowrap w-100">
                        <tr>
                            <td class="col-sm-3 fw-bold">Job Name</td>
                            <td class="col-sm-9">{{ $job['name'] }}</td>
                        </tr>
                        <tr>
                            <td class="col-sm-3 fw-bold">Site ID</td>
                            <td class="col-sm-9">{{ $job['site_id'] }}</td>
                        </tr>
                        <tr>
                            <td class="col-sm-3 fw-bold">Platform</td>
                            <td class="col-sm-9">{{ $job['platform'] }}</td>
                        </tr>
                        <tr>
                            <td class="col-sm-3 fw-bold">Developer</td>
                            <td class="col-sm-9">{{ $job['developer'] }}</td>
                        </tr>
                        <tr>
                            <td class="col-sm-3 fw-bold">Type of Request</td>
                            <td class="col-sm-9">{{ $job['request_type'] }}</td>
                        </tr>
                        <tr>
                            <td class="col-sm-3 fw-bold">Num of Pages</td>
                            <td class="col-sm-9">{{ $job['request_volume'] }}</td>
                        </tr>
                        <tr>
                            <td class="col-sm-3 fw-bold">Salesforce Link</td>
                            <td class="col-sm-9"><a href="{{ $job['salesforce_link'] }}" target="_blank" class="text-info">{{ $job['salesforce_link'] }}</a></td>
                        </tr>
                        <tr>
                            <td class="col-sm-3 fw-bold">Special Request</td>
                            <td class="col-sm-9">{{ $job['is_special_request'] }}</td>
                        </tr>
                        <tr>
                            <td class="col-sm-3 fw-bold">Comments for Special Request</td>
                            <td class="col-sm-9">{{ $job['comments'] }}</td>
                        </tr>
                        <tr>
                            <td class="col-sm-3 fw-bold">Additional Comments</td>
                            <td class="col-sm-9">{{ $job['addon_comments'] }}</td>
                        </tr>
                        <tr>
                            <td class="col-sm-3 fw-bold">SLA Agreed</td>
                            <td class="col-sm-9"><span class="badge bg-primary">{{ $job['agreed_sla'] }} hrs</span></td>
                        </tr>
                        <tr>
                            <td class="col-sm-3 fw-bold">SLA Missed</td>
                            <td class="col-sm-9">@if($job['sla_missed']) <span class="text-danger">Yes</span> @else <span class="text-success">No</span> @endif</td>
                        </tr>
                        <tr>
                            <td class="col-sm-3 fw-bold">Template Followed</td>
                            <td class="col-sm-9">{{ $job['start_at'] }}</td>
                        </tr>
                        <tr>
                            <td class="col-sm-3 fw-bold">Any Issue with Template</td>
                            <td class="col-sm-9">{{ $job['end_at'] }}</td>
                        </tr>
                        <tr>
                            <td class="col-sm-3 fw-bold">Comments for Issue in Template</td>
                            <td class="col-sm-9">{{ $job['end_at'] }}</td>
                        </tr>
                        <tr>
                            <td class="col-sm-3 fw-bold">Automation Recommended</td>
                            <td class="col-sm-9">{{ $job['end_at'] }}</td>
                        </tr>
                        <tr>
                            <td class="col-sm-3 fw-bold">Comments for Automation Recommendation</td>
                            <td class="col-sm-9">{{ $job['end_at'] }}</td>
                        </tr>
                        <tr>
                            <td class="col-sm-3 fw-bold">Image(s) used from Localstock</td>
                            <td class="col-sm-9">{{ $job['end_at'] }}</td>
                        </tr>
                        <tr>
                            <td class="col-sm-3 fw-bold">Image(s) provided by customer</td>
                            <td class="col-sm-9">{{ $job['end_at'] }}</td>
                        </tr>
                        <tr>
                            <td class="col-sm-3 fw-bold">Num of new images used</td>
                            <td class="col-sm-9">{{ $job['end_at'] }}</td>
                        </tr>
                        <tr>
                            <td class="col-sm-3 fw-bold">Shared Folder Location</td>
                            <td class="col-sm-9">{{ $job['end_at'] }}</td>
                        </tr>
                        <tr>
                            <td class="col-sm-3 fw-bold">Developer Comments</td>
                            <td class="col-sm-9">{{ $job['end_at'] }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
