<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use App\Traits\ResponseTraits;
use App\Services\AuditLogsServices;
use Facades\App\Http\Helpers\CredentialsHelper;
use App\Http\Requests\AuditLogStoreRequest;

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

    public function submitFeedback(AuditLogStoreRequest $request)
    {
        $result = $this->successResponse("Quality Check saved successfully!");
        try {
            $request['end_at'] = Carbon::now();
            AuditLog::findOrfail($request->edit_id)->update($request->except('edit_id'));
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

        return view('pages.admin.jobs.viewqc.index', compact('user','job'));
    }
}
