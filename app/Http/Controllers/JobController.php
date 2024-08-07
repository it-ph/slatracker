<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Job;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use App\Services\JobsServices;
use App\Traits\ResponseTraits;
use App\Http\Requests\JobStoreRequest;
use App\Http\Requests\JobSendForQCRequest;
use App\Http\Requests\JobSubmitDetailsRequest;
use Facades\App\Http\Helpers\CredentialsHelper;
use App\Http\Requests\JobUpdateExternalQualityRequest;

class JobController extends Controller
{
    use ResponseTraits;

    public function __construct()
    {
        $this->model = new Job();
        $this->service = new JobsServices();
    }

    public function thecredentials()
    {
        return CredentialsHelper::get_set_credentials();
    }

    /** PENDING JOBS */
    public function pendingJob()
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

    /** DEV */
    public function myJob()
    {
        $result = $this->successResponse('Jobs loaded successfully!');
        try
        {
            $result["data"] =  $this->service->loadDevJobs();
        } catch (\Throwable $th)
        {
            return $this->errorResponse($th);
        }

        return $this->returnResponse($result);
    }

    public function view($id)
    {
        $user = $this->thecredentials();
        $job = $this->service->show($id);

        if(!$job){
            return view('errors.404');
        }

        return view('pages.admin.jobs.view.index', compact('user','job'));
    }

    public function startJob($id)
    {
        $result = $this->successResponse("Job started successfully!");
        try {
            $job = Job::findOrfail($id);
            $status = 'In Progress';

            $job->update([
                'status' => $status,
                'start_at' => Carbon::now(),
            ]);
        } catch (\Throwable $th) {
            $result = $this->errorResponse($th);
        }

        return $this->returnResponse($result);
    }

    public function submitDetails(JobSubmitDetailsRequest $request)
    {
        $result = $this->successResponse('Job details saved successfully!');
        try {
            Job::findOrfail($request->edit_id)->update($request->except('edit_id'));
        } catch (\Throwable $th)
        {
            $result = $this->errorResponse($th);
        }

        return $result;
    }

    public function sendForQC(JobSendForQCRequest $request)
    {
        $result = $this->successResponse('Job Sent for QC successfully!');
        try {
            // update job status
            Job::findOrfail($request->edit_id)->update([
                'status' => 'Quality Check',
                'dev_comments' => $request->dev_comments,
            ]);

            // get qc round
            $audit_log = AuditLog::query()
                ->where('job_id', $request->edit_id)
                ->count();

            // increment qc round
            $qc_round = $audit_log + 1;

            // create audit log
            AuditLog::create([
                'created_by' => auth()->user()->id,
                'client_id' => auth()->user()->client_id,
                'job_id' => $request->edit_id,
                'preview_link' => $request->preview_link,
                'self_qc' => $request->self_qc,
                'dev_comments' => $request->dev_comments,
                'qc_round' => $qc_round,
            ]);
        } catch (\Throwable $th)
        {
            $result = $this->errorResponse($th);
        }

        return $result;
    }

    /** AUDITOR */
    // public function qualityCheck()
    // {
    //     $result = $this->successResponse('Jobs loaded successfully!');
    //     try
    //     {
    //         $result["data"] =  $this->service->loadPendingQC();
    //     } catch (\Throwable $th)
    //     {
    //         return $this->errorResponse($th);
    //     }

    //     return $this->returnResponse($result);
    // }

    // public function viewQC($id)
    // {
    //     $user = $this->thecredentials();
    //     $job = $this->service->showQC($id);

    //     if(!$job){
    //         return view('errors.404');
    //     }

    //     return view('pages.admin.jobs.qc.index', compact('user','job'));
    // }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result = $this->successResponse('Jobs loaded successfully!');
        try
        {
            $result["data"] =  $this->service->load();
        } catch (\Throwable $th)
        {
            return $this->errorResponse($th);
        }

        return $this->returnResponse($result);
    }

    public function store(JobStoreRequest $request)
    {
        $result = $this->successResponse('Job created successfully!');
        try{
            if($request->edit_id === null)
            {
                $request['request_sla_id'] = $request->request_sla_id;
                $request['client_id'] = auth()->user()->client_id;
                $request['created_by'] = auth()->user()->id;
                $job = Job::create($request->except(['edit_id','agreed_sla']));
            }
            else
            {
                $result = $this->update($request, $request->edit_id);
            }
        } catch (\Throwable $th) {
            return $this->errorResponse($th);
        }

        return $this->returnResponse($result);
    }

    public function showJob($id)
    {
        $result = $this->successResponse('Job retrieved successfully!');
        try {
            $result["data"] = Job::findOrfail($id);
        } catch (\Throwable $th) {
            return $this->errorResponse($th);
        }

        return $this->returnResponse($result);
    }

    public function update($request, $id)
    {
        $result = $this->successResponse('Job updated successfully!');
        try {
            Job::findOrfail($id)->update($request->except('edit_id'));
        } catch (\Throwable $th)
        {
            $result = $this->errorResponse($th);
        }

        return $result;
    }

    public function updateExternalQuality(JobUpdateExternalQualityRequest $request)
    {
        $result = $this->successResponse('External Quality details saved successfully!');
        try {
            Job::findOrfail($request->edit_id)->update([
                'external_quality' => $request->external_quality,
                'c_external_quality' => $request->c_external_quality
            ]);
        } catch (\Throwable $th)
        {
            $result = $this->errorResponse($th);
        }

        return $result;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $job = Job::findOrfail($id);
        $result = $this->successResponse('Job deleted successfully!');
        try {
            $job->delete();
        } catch (\Throwable $th)
        {
            return $this->errorResponse($th);
        }

        return $this->returnResponse($result);
    }
}
