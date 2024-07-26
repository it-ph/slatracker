<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use App\Traits\ResponseTraits;
use App\Services\DepartmentsServices;
use App\Http\Requests\DepartmentStoreRequest;

class DepartmentController extends Controller
{
    use ResponseTraits;

    public function __construct()
    {
        $this->model = new Department();
        $this->service = new DepartmentsServices();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result = $this->successResponse('Departments loaded successfully!');
        try
        {
            $result["data"] =  $this->service->load();
        } catch (\Throwable $th)
        {
            return $this->errorResponse($th);
        }

        return $this->returnResponse($result);
    }

    public function store(DepartmentStoreRequest $request)
    {
        $result = $this->successResponse('Department created successfully!');
        try{
            if($request->edit_id === null)
            {
                $department = Department::create($request->except('edit_id'));
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
        $result = $this->successResponse('Department retrieved successfully!');
        try {
            $result["data"] = Department::findOrfail($id);
        } catch (\Throwable $th) {
            return $this->errorResponse($th);
        }

        return $this->returnResponse($result);
    }

    public function update($request, $id)
    {
        $result = $this->successResponse('Department updated successfully!');
        try {
            Department::findOrfail($id)->update($request->except('edit_id'));
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
        $department = Department::findOrfail($id);
        $result = $this->successResponse('Department deleted successfully!');
        try {
            $department->delete();
        } catch (\Throwable $th)
        {
            return $this->errorResponse($th);
        }

        return $this->returnResponse($result);
    }
}
