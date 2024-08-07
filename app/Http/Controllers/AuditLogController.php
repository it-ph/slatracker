<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Job;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use App\Traits\ResponseTraits;
use App\Services\AuditLogsServices;
use App\Http\Requests\AuditLogStoreRequest;
use Facades\App\Http\Helpers\CredentialsHelper;

class AuditLogController extends Controller
{
    use ResponseTraits;

    public function __construct()
    {
        $this->model = new AuditLog();
        $this->service = new AuditLogsServices();
    }

    public function thecredentials()
    {
        return CredentialsHelper::get_set_credentials();
    }

    /** AUDITOR */
    public function qualityCheck()
    {
        $result = $this->successResponse('Jobs loaded successfully!');
        try
        {
            $result["data"] =  $this->service->loadPendingQCs();
        } catch (\Throwable $th)
        {
            return $this->errorResponse($th);
        }

        return $this->returnResponse($result);
    }

    public function pickJob($id)
    {
        $result = $this->successResponse("Job picked successfully!");
        try {
            $audit_log = AuditLog::findOrfail($id)->update([
                'auditor_id' => auth()->user()->id,
                'start_at' => Carbon::now()
            ]);
        } catch (\Throwable $th) {
            $result = $this->errorResponse($th);
        }

        return $this->returnResponse($result);
    }

    public function releaseJob($id)
    {
        $result = $this->successResponse("Job released successfully!");
        try {
            $audit_log = AuditLog::findOrfail($id)->update([
                'auditor_id' => null,
                'start_at' => null
            ]);
        } catch (\Throwable $th) {
            $result = $this->errorResponse($th);
        }

        return $this->returnResponse($result);
    }

    public function viewQC($id)
    {
        $user = $this->thecredentials();
        $job = $this->service->showQC($id);

        if(!$job){
            return view('errors.404');
        }

        return view('pages.admin.jobs.qc.index', compact('user','job'));
    }

    public function submitFeedback(AuditLogStoreRequest $request)
    {
        $result = $this->successResponse("Quality Check saved successfully!");
        try {
            // update audit log
            $request['end_at'] = Carbon::now();
            $audit_log = AuditLog::where('id',$request->edit_id)->first();
            $audit_log->update($request->except('edit_id'));

            // update job
            $job = Job::where('id',$audit_log->job_id)->first();
            $qc_status = $request->qc_status;
            $status = $qc_status == 'Pass' ? 'Closed' : 'Bounced Back';
            $end_at = $status == 'Closed' ? $request['end_at'] : null;
            $internal_quality = $job->internal_quality ? $job->internal_quality : $qc_status;

            $job->update([
                'status' => $status,
                'end_at' => $end_at,
                'internal_quality' => $internal_quality
            ]);

        } catch (\Throwable $th) {
            $result = $this->errorResponse($th);
        }

        return $this->returnResponse($result);
    }

    public function viewQCLog($id)
    {
        $user = $this->thecredentials();
        $job = $this->service->showQC($id);

        if(!$job){
            return view('errors.404');
        }

        return view('pages.admin.jobs.viewqc.index', compact('user','job'));
    }
}
