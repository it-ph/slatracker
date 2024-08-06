<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="col-md-12">
                    <p class="fw-bold mb-1 text-primary">QC History</p>
                    <table class="table table-bordered table-sm nowrap w-100">
                        <tr>
                            <th class="text-center">QC Round</th>
                            <th class="text-center">QC Auditor</th>
                            <th class="text-center">QC Result</th>
                            <th class="text-center">QC Start Time</th>
                            <th class="text-center">QC End Time</th>
                            <th class="text-center">Self QC Performed</th>
                            <th class="text-center">Action</th>
                        <tr>
                        @if($job['audit_logs'])
                            @foreach ($job['audit_logs'] as $log)
                                <tr>
                                    <td class="text-center">{{ $log['qc_round'] }}</td>
                                    <td class="text-center">{{ $log['auditor'] }}</td>
                                    <td class="text-center"><span class="badge bg-<?php echo $log['qc_status'] == 'Pass' ? 'success' : 'danger'; ?>">{{ $log['qc_status'] }}</span></td>
                                    <td class="text-center">{{ $log['start_at'] }}</td>
                                    <td class="text-center">{{ $log['end_at'] }}</td>
                                    <td class="text-center">{{ $log['self_qc'] }}</td>
                                    <td class="text-center">
                                        <a href="{{ url('viewqualitycheck') }}/{{ $log['audit_log_id'] }}" class="btn btn-info btn-sm waves-effect waves-light" title="View Quality Check"><i class="fas fa-eye"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
