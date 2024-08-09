<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use App\Traits\ResponseTraits;
use App\Services\EventsServices;
use App\Http\Requests\EventStoreRequest;

class EventController extends Controller
{
    use ResponseTraits;

    public function __construct()
    {
        $this->model = new Event();
        $this->service = new EventsServices();
    }

    public function store(EventStoreRequest $request)
    {
        $result = $this->successResponse('Event created successfully!');
        try{
            if($request->edit_id === null)
            {
                $request['created_by'] = auth()->user()->id;
                $request['client_id'] = auth()->user()->client_id;
                $event = Event::create($request->except('edit_id'));
            }
            else
            {
                $request['updated_by'] = auth()->user()->id;
                $request['client_id'] = auth()->user()->client_id;
                $result = $this->update($request, $request->edit_id);
            }
        } catch (\Throwable $th) {
            return $this->errorResponse($th);
        }

        return $this->returnResponse($result);
    }

    public function show($id)
    {
        $result = $this->successResponse('Event retrieved successfully!');
        try {
            $result["data"] = Event::findOrfail($id);
        } catch (\Throwable $th) {
            return $this->errorResponse($th);
        }

        return $this->returnResponse($result);
    }

    public function update($request, $id)
    {
        $result = $this->successResponse('Event updated successfully!');
        try {
            Event::findOrfail($id)->update($request->except('edit_id'));
        } catch (\Throwable $th)
        {
            $result = $this->errorResponse($th);
        }

        return $result;
    }

    public function destroy($id)
    {
        $client = Event::findOrfail($id);
        $result = $this->successResponse('Event deleted successfully!');
        try {
            $client->delete();
        } catch (\Throwable $th)
        {
            return $this->errorResponse($th);
        }

        return $this->returnResponse($result);
    }
}
