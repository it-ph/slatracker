<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;
use App\Services\JobsServices;
use App\Traits\ResponseTraits;
use App\Http\Requests\JobStoreRequest;

class JobController extends Controller
{
    use ResponseTraits;

    public function __construct()
    {
        $this->model = new Job();
        $this->service = new JobsServices();
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

    /** AUDITOR */
    public function qualityCheck()
    {
        $result = $this->successResponse('Jobs loaded successfully!');
        try
        {
            $result["data"] =  $this->service->loadPendingQC();
        } catch (\Throwable $th)
        {
            return $this->errorResponse($th);
        }

        return $this->returnResponse($result);
    }


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

    public function show($id)
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\department  $department
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
