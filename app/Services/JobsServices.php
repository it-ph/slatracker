<?php

namespace App\Services;

use App\Models\Job;
use App\Models\AuditLog;
use Facades\App\Http\Helpers\TaskHelper;

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
            'therequestsla:id,agreed_sla',
            'thedeveloper:id,username',
        ])
        ->select('id','name','request_type_id','request_volume_id','request_sla_id','special_request','created_at','start_at','end_at','time_taken','sla_missed','internal_quality','external_quality','developer_id','status')
        ->orderBy('created_at','DESC')
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
            $name = '<a href="'.env('APP_URL').'/viewjob/'.$value->id.'" class="text-info">'. $value->name .'</a>';
            $request_type = $value->therequesttype ? $value->therequesttype->name : '-';
            $request_volume = $value->therequestvolume ? $value->therequestvolume->name : '-';
            $special_request = $value->special_request ? 'Yes' : 'No';
            $created_at = $value->created_at ? date('d-M-y h:i:s a', strtotime($value->created_at)) : '-';
            $start_at = $value->start_at ? date('d-M-y h:i:s a', strtotime($value->start_at)) : '-';
            $end_at = $value->end_at ? date('d-M-y h:i:s a', strtotime($value->end_at)) : '-';
            $agreed_sla = $value->therequestsla ? TaskHelper::convertTime($value->therequestsla->agreed_sla) : '-';
            $time_taken = $value->time_taken ? $value->time_taken : '-';
            $sla_missed = $value->sla_missed ? '<span class="text-danger">Yes</span>' : '<span class="text-success">No</span>';
            $internal_quality = $value->internal_quality ? $value->internal_quality : '-';
            $external_quality = $value->external_quality ? $value->external_quality : '-';
            $developer = $value->thedeveloper ? $value->thedeveloper->username : '-';

            $badge_status = $value->status;
            switch ($badge_status) {
                case "Not Started":
                    $badge = 'secondary';
                    break;
                case "In Progress":
                    $badge = 'primary';
                    break;
                case "Quality Check":
                    $badge = 'info';
                    break;
                    break;
                case "Bounced Back":
                    $badge = 'danger';
                    break;
                case "Closed":
                    $badge = 'success';
                    break;
            }

            $status = '<span class="badge bg-'.$badge.'">'.$value->status.'</span>';
            $action ='<button type="button" class="btn btn-info btn-sm waves-effect waves-light" title="View Job" onclick=JOB.show('.$value->id.')><i class="fas fa-eye"></i></button>
            <button type="button" class="btn btn-warning btn-sm waves-effect waves-light" title="Edit Job" onclick=JOB.show('.$value->id.')><i class="fas fa-pencil-alt"></i></button>';

            $datastorage[] = [
                'id' => $value->id,
                'name' => $name,
                'request_type' => $request_type,
                'request_volume' => $request_volume,
                'special_request' => $special_request,
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

    // PENDING JOBS
    public function loadPendingJobs()
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
            'therequestsla:id,agreed_sla',
            'thedeveloper:id,username',
        ])
        ->select('id','name','request_type_id','request_volume_id','request_sla_id','special_request','created_at','start_at','time_taken','sla_missed','developer_id','status')
        ->where('status','<>','closed')
        ->orderBy('created_at','DESC')
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
            $name = '<a href="'.env('APP_URL').'/qualitycheck/'.$value->id.'" class="text-info">'. $value->name .'</a>';
            $request_type = $value->therequesttype ? $value->therequesttype->name : '-';
            $request_volume = $value->therequestvolume ? $value->therequestvolume->name : '-';
            $special_request = $value->special_request ? 'Yes' : 'No';
            $created_at = $value->created_at ? date('d-M-y h:i:s a', strtotime($value->created_at)) : '-';
            $start_at = $value->start_at ? date('d-M-y h:i:s a', strtotime($value->start_at)) : '-';
            $agreed_sla = $value->therequestsla ? TaskHelper::convertTime($value->therequestsla->agreed_sla) : '-';
            $time_taken = $value->time_taken ? $value->time_taken : '-';
            $sla_missed = $value->sla_missed ? '<span class="text-danger">Yes</span>' : '<span class="text-success">No</span>';
            $p_sla_miss = $value->sla_missed ? '<span class="text-danger">Yes</span>' : '<span class="text-success">No</span>';
            $developer = $value->thedeveloper ? $value->thedeveloper->username : '-';

            $badge_status = $value->status;
            switch ($badge_status) {
                case "Not Started":
                    $badge = 'secondary';
                    break;
                case "In Progress":
                    $badge = 'primary';
                    break;
                case "Quality Check":
                    $badge = 'info';
                    break;
                    break;
                case "Bounced Back":
                    $badge = 'danger';
                    break;
                case "Closed":
                    $badge = 'success';
                    break;
            }

            $status = '<span class="badge bg-'.$badge.'">'.$value->status.'</span>';

            $datastorage[] = [
                'id' => $value->id,
                'name' => $name,
                'request_type' => $request_type,
                'request_volume' => $request_volume,
                'special_request' => $special_request,
                'created_at' => $created_at,
                'start_at' => $start_at,
                'agreed_sla' => $agreed_sla,
                'time_taken' => $time_taken,
                'sla_missed' => $sla_missed,
                'p_sla_miss' => $p_sla_miss,
                'developer' => $developer,
                'status' => $status,
            ];
        }

        return $datastorage;
    }

    // DEVELOPER
    public function loadDevJobs()
    {
        $datastorage = [];
        $jobs = Job::with([
            'therequesttype:id,name',
            'therequestvolume:id,name',
            'therequestsla:id,agreed_sla',
            'thedeveloper:id,username',
        ])
        ->select('id','name','request_type_id','request_volume_id','request_sla_id','special_request','created_at','start_at','end_at','time_taken','sla_missed','internal_quality','external_quality','developer_id','status')
        ->devs()
        ->orderBy('created_at','DESC')
        ->get();

        foreach($jobs as $value) {
            $name = '<a href="'.env('APP_URL').'/viewjob/'.$value->id.'" class="text-info">'. $value->name .'</a>';
            $request_type = $value->therequesttype ? $value->therequesttype->name : '-';
            $request_volume = $value->therequestvolume ? $value->therequestvolume->name : '-';
            $special_request = $value->special_request ? 'Yes' : 'No';
            $created_at = $value->created_at ? date('d-M-y h:i:s a', strtotime($value->created_at)) : '-';
            $start_at = $value->start_at ? date('d-M-y h:i:s a', strtotime($value->start_at)) : '-';
            $end_at = $value->end_at ? date('d-M-y h:i:s a', strtotime($value->end_at)) : '-';
            $agreed_sla = $value->therequestsla ? TaskHelper::convertTime($value->therequestsla->agreed_sla) : '-';
            $time_taken = $value->time_taken ? $value->time_taken : '-';
            $sla_missed = $value->sla_missed ? '<span class="text-danger">Yes</span>' : '<span class="text-success">No</span>';
            $p_sla_miss = $value->sla_missed ? '<span class="text-danger">Yes</span>' : '<span class="text-success">No</span>';

            $badge_status = $value->status;
            switch ($badge_status) {
                case "Not Started":
                    $badge = 'secondary';
                    break;
                case "In Progress":
                    $badge = 'primary';
                    break;
                case "Quality Check":
                    $badge = 'info';
                    break;
                    break;
                case "Bounced Back":
                    $badge = 'danger';
                    break;
                case "Closed":
                    $badge = 'success';
                    break;
            }

            $status = '<span class="badge bg-'.$badge.'">'.$value->status.'</span>';

            $datastorage[] = [
                'id' => $value->id,
                'name' => $name,
                'request_type' => $request_type,
                'request_volume' => $request_volume,
                'special_request' => $special_request,
                'created_at' => $created_at,
                'start_at' => $start_at,
                'end_at' => $end_at,
                'agreed_sla' => $agreed_sla,
                'time_taken' => $time_taken,
                'sla_missed' => $sla_missed,
                'p_sla_miss' => $p_sla_miss,
                'status' => $status,
            ];
        }

        return $datastorage;
    }

    // AUDITOR
    public function loadPendingQC()
    {
        $datastorage = [];


        $pending_qcs = AuditLog::with([
            'thejob:id,name,request_type_id,request_volume_id,request_sla_id,special_request,time_taken,sla_missed,developer_id',
            'thejob.therequestsla:id,agreed_sla',
            'thejob.therequesttype:id,name',
            'thejob.therequestvolume:id,name',
            'thejob.thedeveloper:id,username'
        ])
        ->select('id','job_id','qc_round','auditor_id','created_at')
        ->where('end_at',null)
        ->orderBy('created_at','DESC')
        ->get();

        foreach($pending_qcs as $value) {
            $name = auth()->user()->id == $value->auditor_id ? '<a href="'.env('APP_URL').'/qualitycheck/'.$value->job_id.'" class="text-info">'. $value->thejob->name .'</a>' : $value->thejob->name;
            $request_type = $value->thejob->therequesttype ? $value->thejob->therequesttype->name : '-';
            $request_volume = $value->thejob->therequestvolume ? $value->thejob->therequestvolume->name : '-';
            $special_request = $value->thejob->special_request ? 'Yes' : 'No';
            $created_at = $value->created_at ? date('d-M-y h:i:s a', strtotime($value->created_at)) : '-';
            $agreed_sla = $value->thejob->therequestsla ? TaskHelper::convertTime($value->thejob->therequestsla->agreed_sla) : '-';
            $time_taken = $value->thejob->time_taken ? $value->thejob->time_taken : '-';
            $sla_missed = $value->thejob->sla_missed ? '<span class="text-danger">Yes</span>' : '<span class="text-success">No</span>';
            $developer = $value->thejob->thedeveloper ? $value->thejob->thedeveloper->username : '-';
            $qc_round = $value->qc_round ? $value->qc_round : '-';
            $auditor = $value->theauditor ? $value->theauditor->username : '-';

            if($value->auditor_id)
            {
                $action = auth()->user()->id == $value->auditor_id ?
                    '<button type="button" class="btn btn-info btn-sm waves-effect waves-light" id="btn_release_'.$value->id.'" title="Release Job" onclick=JOB.show('.$value->id.')><i class="fa fa-share"></i></button>' : '-';
            }
            else
            {
                $action = '<button type="button" class="btn btn-primary btn-sm waves-effect waves-light" id="btn_pick_'.$value->id.'" title="Pick Job" onclick=JOB.pick('.$value->id.')><i class="fa fa-check-circle"></i></button>';
            }

            $datastorage[] = [
                'id' => $value->id,
                'name' => $name,
                'request_type' => $request_type,
                'request_volume' => $request_volume,
                'special_request' => $special_request,
                'created_at' => $created_at,
                'agreed_sla' => $agreed_sla,
                'time_taken' => $time_taken,
                'sla_missed' => $sla_missed,
                'developer' => $developer,
                'qc_round' => $qc_round,
                'auditor' => $auditor,
                'action' => $action,
            ];
        }

        return $datastorage;
    }

    // VIEW JOB
    public function show($id)
    {
        $value = Job::with([
            'therequesttype:id,name',
            'therequestvolume:id,name',
            'therequestsla:id,agreed_sla',
            'thedeveloper:id,username',
        ])
        ->where('id',$id)
        ->first();

        if(!$value){
            return null;
        }

        $name = $value->name;
        $site_id = $value->site_id;
        $platform = $value->platform;
        $developer = $value->thedeveloper ? $value->thedeveloper->username : '-';
        $developer_id = $value->thedeveloper ? $value->developer_id : '-';
        $request_type = $value->therequesttype ? $value->therequesttype->name : '-';
        $request_volume = $value->therequestvolume ? $value->therequestvolume->name : '-';
        $salesforce_link = $value->salesforce_link;
        $special_request = $value->special_request ? 'Yes' : 'No';
        $comments_special_request = $value->comments_special_request;
        $addon_comments = $value->addon_comments;
        $agreed_sla = $value->therequestsla ? $value->therequestsla->agreed_sla : '-';
        $sla_missed = $value->sla_missed;
        $start_at = $value->start_at ? date('d-M-y h:i:s A', strtotime($value->start_at)) : '-';
        $end_at = $value->end_at ? date('d-M-y h:i:s A', strtotime($value->end_at)) : '-';
        $status = $value->status;

        // additional details
        $template_followed = $value->template_followed ? 'Yes' : 'No';;
        $template_issue = $value->template_issue ? 'Yes' : 'No';;
        $comments_template_issue = $value->comments_template_issue;
        $auto_recommend = $value->auto_recommend ? 'Yes' : 'No';;
        $comments_auto_recommend = $value->comments_auto_recommend;
        $img_localstock = $value->img_localstock ? 'Yes' : 'No';;
        $img_customer = $value->img_customer ? 'Yes' : 'No';;
        $img_num = $value->img_num;
        $shared_folder_location = $value->shared_folder_location;
        $dev_comments = $value->dev_comments;

        $job = [
            'id' => $value->id,
            'name' => $name,
            'site_id' => $site_id,
            'platform' => $platform,
            'developer' => $developer,
            'developer_id' => $developer_id,
            'request_type' => $request_type,
            'request_volume' => $request_volume,
            'salesforce_link' => $salesforce_link,
            'special_request' => $special_request,
            'comments_special_request' => $comments_special_request,
            'addon_comments' => $addon_comments,
            'agreed_sla' => $agreed_sla,
            'sla_missed' => $sla_missed,
            'start_at' => $start_at,
            'end_at' => $end_at,
            'status' => $status,

            // additional details
            'template_followed' => $template_followed,
            'template_issue' => $template_issue,
            'comments_template_issue' => $comments_template_issue,
            'auto_recommend' => $auto_recommend,
            'comments_auto_recommend' => $comments_auto_recommend,
            'img_localstock' => $img_localstock,
            'img_customer' => $img_customer,
            'img_num' => $img_num,
            'shared_folder_location' => $shared_folder_location,
            'dev_comments' => $dev_comments,
        ];

        return $job;
    }

    // QUALITY CHECK
    public function showQC($id)
    {
        $value = Job::with([
            'therequesttype:id,name',
            'therequestvolume:id,name',
            'therequestsla:id,agreed_sla',
            'thedeveloper:id,username',
        ])
        ->where('id',$id)
        ->first();

        if(!$value){
            return null;
        }

        $name = $value->name;
        $site_id = $value->site_id;
        $platform = $value->platform;
        $developer = $value->thedeveloper ? $value->thedeveloper->username : '-';
        $developer_id = $value->thedeveloper ? $value->developer_id : '-';
        $request_type = $value->therequesttype ? $value->therequesttype->name : '-';
        $request_volume = $value->therequestvolume ? $value->therequestvolume->name : '-';
        $salesforce_link = $value->salesforce_link;
        $special_request = $value->special_request ? 'Yes' : 'No';
        $comments_special_request = $value->comments_special_request;
        $addon_comments = $value->addon_comments;
        $agreed_sla = $value->therequestsla ? $value->therequestsla->agreed_sla : '-';
        $sla_missed = $value->sla_missed;
        $start_at = $value->start_at ? date('d-M-y h:i:s A', strtotime($value->start_at)) : '-';
        $end_at = $value->end_at ? date('d-M-y h:i:s A', strtotime($value->end_at)) : '-';
        $status = $value->status;

        // additional details
        $template_followed = $value->template_followed ? 'Yes' : 'No';;
        $template_issue = $value->template_issue ? 'Yes' : 'No';;
        $comments_template_issue = $value->comments_template_issue;
        $auto_recommend = $value->auto_recommend ? 'Yes' : 'No';;
        $comments_auto_recommend = $value->comments_auto_recommend;
        $img_localstock = $value->img_localstock ? 'Yes' : 'No';;
        $img_customer = $value->img_customer ? 'Yes' : 'No';;
        $img_num = $value->img_num;
        $shared_folder_location = $value->shared_folder_location;
        $dev_comments = $value->dev_comments;

        // qc details
        $audit_log = AuditLog::query()
            ->where('job_id', $value->id)
            ->select('id','job_id','preview_link','self_qc','dev_comments','qc_round','auditor_id')
            ->latest()
            ->first();

        $preview_link = $audit_log ? $audit_log->preview_link : '';
        $self_qc = $audit_log ? 'Yes' : 'No';
        $audit_dev_comments = $audit_log ? $audit_log->dev_comments : '';
        $auditor = $audit_log->auditor_id;

        $job = [
            'id' => $value->id,
            'name' => $name,
            'site_id' => $site_id,
            'platform' => $platform,
            'developer' => $developer,
            'developer_id' => $developer_id,
            'request_type' => $request_type,
            'request_volume' => $request_volume,
            'salesforce_link' => $salesforce_link,
            'special_request' => $special_request,
            'comments_special_request' => $comments_special_request,
            'addon_comments' => $addon_comments,
            'agreed_sla' => $agreed_sla,
            'sla_missed' => $sla_missed,
            'start_at' => $start_at,
            'end_at' => $end_at,
            'status' => $status,

            // additional details
            'template_followed' => $template_followed,
            'template_issue' => $template_issue,
            'comments_template_issue' => $comments_template_issue,
            'auto_recommend' => $auto_recommend,
            'comments_auto_recommend' => $comments_auto_recommend,
            'img_localstock' => $img_localstock,
            'img_customer' => $img_customer,
            'img_num' => $img_num,
            'shared_folder_location' => $shared_folder_location,
            'dev_comments' => $dev_comments,

            // qc details
            'preview_link' => $preview_link,
            'self_qc' => $self_qc,
            'audit_dev_comments' => $audit_dev_comments,
            'auditor' => $auditor,
        ];

        return $job;
    }
}
