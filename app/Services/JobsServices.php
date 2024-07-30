<?php

namespace App\Services;

use App\Models\Job;

class JobsServices {
    public function load()
    {
        // $user = User::with('theroles:id,user_id,name')->findOrFail(auth()->user()->id);
        // $roles = [];
        // foreach ($user->theroles as $role) {
        //     array_push($roles, $role->name);
        // }

        $datastorage = [];
        $jobs = Job::with([
            'therequesttype:id,name',
            'therequestvolume:id,name',
            'thedeveloper:id,username',
        ])
        ->select('id','name','request_type_id','request_volume_id','is_special_request','created_at','start_at','end_at','agreed_sla','time_taken','sla_missed','internal_quality','external_quality','developer_id','status')
        ->get();

        // // ADMIN
        // if(in_array('admin',$roles))
        // {
        //     $jobs = $jobs->get();
        // }
        // // TEAM LEAD, MANAGER
        // else
        // {
        //     $jobs = $jobs->get();
        // }

        foreach($jobs as $value) {
            $name = $value->name;
            $request_type = $value->therequesttype ? $value->therequesttype->name : '-';
            $request_volume = $value->therequestvolume ? $value->therequestvolume->name : '-';
            $is_special_request = $value->is_special_request ? 'Yes' : 'No';
            $created_at = $value->created_at ? date('d-M-y h:i:s a', strtotime($value->created_at)) : '-';
            $start_at = $value->start_at ? date('d-M-y h:i:s a', strtotime($value->start_at)) : '-';
            $end_at = $value->end_at ? date('d-M-y h:i:s a', strtotime($value->end_at)) : '-';
            $agreed_sla = $value->agreed_sla;
            $time_taken = $value->time_taken;
            $sla_missed = $value->sla_missed ? 'Yes' : 'No';
            $internal_quality = $value->internal_quality ? $value->internal_quality : '-';
            $external_quality = $value->external_quality ? $value->external_quality : '-';
            $developer = $value->thedeveloper ? $value->thedeveloper->username : '-';

            $badge_status = $value->status;
            switch ($badge_status) {
                case "not started":
                    $badge = 'danger';
                    break;
                case "in progress":
                    $badge = 'primary';
                    break;
                case "quality check":
                    $badge = 'info';
                    break;
                case "closed":
                    $badge = 'success';
                    break;
            }

            $status = '<span class="badge bg-'.$badge.'">'.ucwords($value->status).'</span>';
            $action ='<button type="button" class="btn btn-info btn-sm waves-effect waves-light" title="View Job" onclick=JOB.show('.$value->id.')><i class="fas fa-eye"></i></button>
            <button type="button" class="btn btn-warning btn-sm waves-effect waves-light" title="Edit Job" onclick=JOB.show('.$value->id.')><i class="fas fa-pencil-alt"></i></button>';

            $datastorage[] = [
                'id' => $value->id,
                'name' => $name,
                'request_type' => $request_type,
                'request_volume' => $request_volume,
                'is_special_request' => $is_special_request,
                'created_at' => $created_at,
                'start_at' => $start_at,
                'end_at' => $end_at,
                'agreed_sla' => $agreed_sla,
                'time_taken' => $time_taken,
                'sla_missed' => $sla_missed,
                'internal_quality' => $internal_quality,
                'external_quality' => $external_quality,
                'developer' => $developer,
                'status' => $status,
                'action' => $action,
            ];
        }

        return $datastorage;
    }
}
