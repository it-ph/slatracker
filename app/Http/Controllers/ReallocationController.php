<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;
use App\Traits\ResponseTraits;
use App\Services\ReallocationServices;
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

    /** PENDING QCS */
    public function pendingQC()
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
}
