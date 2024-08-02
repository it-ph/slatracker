<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use Illuminate\Http\Request;
use App\Traits\ResponseTraits;
use App\Services\AuditLogsServices;
use App\Http\Requests\AuditLogStoreRequest;

class AuditLogController extends Controller
{
    use ResponseTraits;

    public function __construct()
    {
        $this->model = new AuditLog();
        $this->service = new AuditLogsServices();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result = $this->successResponse('Pending QC loaded successfully!');
        try
        {
            $result["data"] =  $this->service->load();
        } catch (\Throwable $th)
        {
            return $this->errorResponse($th);
        }

        return $this->returnResponse($result);
    }

    public function store(AuditLogStoreRequest $request)
    {
        $result = $this->successResponse('Audit Log created successfully!');
        try{
            if($request->edit_id === null)
            {
                $request['request_sla_id'] = $request->request_sla_id;
                $request['client_id'] = auth()->user()->client_id;
                $request['created_by'] = auth()->user()->id;
                $audit_log = AuditLog::create($request->except(['edit_id','agreed_sla']));
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
        $result = $this->successResponse('Audit Log retrieved successfully!');
        try {
            $result["data"] = AuditLog::findOrfail($id);
        } catch (\Throwable $th) {
            return $this->errorResponse($th);
        }

        return $this->returnResponse($result);
    }

    public function update($request, $id)
    {
        $result = $this->successResponse('Audit Log updated successfully!');
        try {
            AuditLog::findOrfail($id)->update($request->except('edit_id'));
        } catch (\Throwable $th)
        {
            $result = $this->errorResponse($th);
        }

        return $result;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AuditLog  $audit_log
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $audit_log = AuditLog::findOrfail($id);
        $result = $this->successResponse('Audit Log deleted successfully!');
        try {
            $audit_log->delete();
        } catch (\Throwable $th)
        {
            return $this->errorResponse($th);
        }

        return $this->returnResponse($result);
    }
}
