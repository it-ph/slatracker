<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;
use App\Traits\ResponseTraits;
use App\Services\ReallocationServices;
use App\Http\Requests\ReallocateQCRequest;
use App\Http\Requests\ReallocateJobRequest;
use App\Models\AuditLog;
use Facades\App\Http\Helpers\CredentialsHelper;

class ReallocationController extends Controller
{
    use ResponseTraits;

    public function __construct()
    {
        $this->service = new ReallocationServices();
    }

    public function thecredentials()
    {
        return CredentialsHelper::get_set_credentials();
    }
    
    /** PENDING JOBS */
    public function pendingJobs()
    {
        $result = $this->successResponse('Jobs loaded successfully!');
        try
        {
            $result["data"] =  $this->service->loadPendingJobs();
        } catch (\Throwable $th)
        {
            return $this->errorResponse($th);
        }

        return $this->returnResponse($result);
    }

    public function showJob($id)
    {
        $result = $this->successResponse('Job retrieved successfully!');
        try {
            $result["data"] = Job::where('id',$id)->select('id')->first();
        } catch (\Throwable $th) {
            return $this->errorResponse($th);
        }

        return $this->returnResponse($result);
    }

    public function reallocateJob(ReallocateJobRequest $request)
    {
        $result = $this->successResponse('Job reallocated successfully!');
        try {
            Job::findOrfail($request->edit_id)->update($request->except('edit_id'));
        } catch (\Throwable $th)
        {
            $result = $this->errorResponse($th);
        }

        return $result;
    }

    /** PENDING QCS */
    public function pendingQCs()
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

    public function showQC($id)
    {
        $result = $this->successResponse('QC Job retrieved successfully!');
        try {
            $result["data"] = AuditLog::where('id',$id)->select('id')->first();
        } catch (\Throwable $th) {
            return $this->errorResponse($th);
        }

        return $this->returnResponse($result);
    }

    public function reallocateQC(ReallocateQCRequest $request)
    {
        $result = $this->successResponse('QC Job reallocated successfully!');
        try {
            AuditLog::findOrfail($request->edit_id)->update($request->except('edit_id'));
        } catch (\Throwable $th)
        {
            $result = $this->errorResponse($th);
        }

        return $result;
    }
}
