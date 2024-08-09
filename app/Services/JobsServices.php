<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Job;
use App\Models\User;
use App\Models\AuditLog;
use Facades\App\Http\Helpers\TaskHelper;

class JobsServices
{
    public function getRoles()
    {
        $user = User::with('theroles:id,user_id,name')->findOrFail(auth()->user()->id);
        $roles = [];
        foreach ($user->theroles as $role) {
            array_push($roles, $role->name);
        }

        return $roles;
    }

    public function load()
    {
        $datastorage = [];
        $jobs = Job::with([
            'therequesttype:id,name',
            'therequestvolume:id,name',
            'therequestsla:id,agreed_sla',
            'thedeveloper:id,username',
        ])
        ->select('id','name','request_type_id','request_volume_id','request_sla_id','special_request','created_at','start_at','end_at','time_taken','sla_missed','internal_quality','external_quality','developer_id','status')
        ->orderBy('created_at','DESC');

        $roles = $this->getRoles();

        // ADMIN
        if(in_array('admin',$roles))
        {
            $jobs = $jobs->get();
        }
        // TEAM LEAD, MANAGER
        else
        {
            $jobs = $jobs->clientjobs()->get();
        }

        foreach($jobs as $value) {
            $name = '<a href="'.env('APP_URL').'/viewjob/'.$value->id.'" class="text-info">'. $value->name .'</a>';
            $request_type = $value->therequesttype ? $value->therequesttype->name : '-';
            $request_volume = $value->therequestvolume ? $value->therequestvolume->name : '-';
            $special_request = $value->special_request ? 'Yes' : 'No';
            $created_at = $value->created_at ? date('d-M-y h:i:s a', strtotime($value->created_at)) : '-';
            $start_at = $value->start_at ? date('d-M-y h:i:s a', strtotime($value->start_at)) : '';
            $end_at = $value->end_at ? date('d-M-y h:i:s a', strtotime($value->end_at)) : '';
            $agreed_sla_raw = $value->therequestsla ? $value->therequestsla->agreed_sla : '-';
            $agreed_sla = $value->therequestsla ? TaskHelper::convertTime($value->therequestsla->agreed_sla) : '-';

            if(in_array($value->status,['In Progress','Bounced Back','Quality Check']))
            {
                $t_elapsed = TaskHelper::getTimeElapsedTime($value->start_at);
                $time_taken = TaskHelper::convertTime($t_elapsed);
                $sla_missed = $t_elapsed > $agreed_sla_raw ? '<span class="text-danger">Yes</span>' : '<span class="text-success">No</span>';
            }
            else
            {
                $time_taken = $value->time_taken ? $value->time_taken : '00:00:00';
                $sla_missed = $value->sla_missed ? '<span class="text-danger">Yes</span>' : '<span class="text-success">No</span>';
            }

            $internal_quality = $value->internal_quality ? '<span class="text-'.($value->internal_quality == 'Pass' ? "success" : "danger").'">'.$value->internal_quality.'</span>' : '-';
            $external_quality = $value->external_quality ? '<span class="text-'.($value->external_quality == 'Pass' ? "success" : "danger").'">'.$value->external_quality.'</span>' : '-';
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
            $action ='<a href="'.env('APP_URL').'/viewjob/'.$value->id.'" class="btn btn-primary btn-sm waves-effect waves-light" title="View Job"><i class="fas fa-eye"></i></a>
                    <a href="'.env('APP_URL').'/job/show/'.$value->id.'" class="btn btn-warning btn-sm waves-effect waves-light" title="Edit Job"><i class="fas fa-pencil-alt"></i></a>';

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
        $datastorage = [];

        $jobs = Job::with([
            'therequesttype:id,name',
            'therequestvolume:id,name',
            'therequestsla:id,agreed_sla',
            'thedeveloper:id,username',
        ])
        ->select('id','name','request_type_id','request_volume_id','request_sla_id','special_request','created_at','start_at','time_taken','sla_missed','developer_id','status')
        ->where('status','<>','Closed')
        ->orderBy('created_at','DESC');

        $roles = $this->getRoles();

        // ADMIN
        if(in_array('admin',$roles))
        {
            $jobs = $jobs->get();
        }
        // TEAM LEAD, MANAGER
        else
        {
            $jobs = $jobs->clientjobs()->get();
        }

        foreach($jobs as $value) {
            $name = '<a href="'.env('APP_URL').'/viewjob/'.$value->id.'" class="text-info">'. $value->name .'</a>';
            $request_type = $value->therequesttype ? $value->therequesttype->name : '-';
            $request_volume = $value->therequestvolume ? $value->therequestvolume->name : '-';
            $special_request = $value->special_request ? 'Yes' : 'No';
            $created_at = $value->created_at ? date('d-M-y h:i:s a', strtotime($value->created_at)) : '-';
            $start_at = $value->start_at ? date('d-M-y h:i:s a', strtotime($value->start_at)) : '';
            $agreed_sla = $value->therequestsla ? TaskHelper::convertTime($value->therequestsla->agreed_sla) : '-';
            $time_taken = $value->time_taken ? $value->time_taken : '00:00:00';
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
            $start_at = $value->start_at ? date('d-M-y h:i:s a', strtotime($value->start_at)) : '';
            $end_at = $value->end_at ? date('d-M-y h:i:s a', strtotime($value->end_at)) : '';
            $agreed_sla = $value->therequestsla ? TaskHelper::convertTime($value->therequestsla->agreed_sla) : '-';
            $time_taken = $value->time_taken ? $value->time_taken : '00:00:00';
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

    // VIEW JOB
    public function show($id)
    {
        $value = Job::with([
            'therequesttype:id,name',
            'therequestvolume:id,name',
            'therequestsla:id,agreed_sla',
            'thedeveloper:id,username',
            'theauditlogs:id,job_id,auditor_id,qc_round,qc_status,start_at,end_at,self_qc',
            'theauditlogs.theauditor:id,username'
        ])
        ->where('id',$id);

        $roles = $this->getRoles();

        // ADMIN
        if(in_array('admin',$roles))
        {
            $value = $value->first();
        }
        // TEAM LEAD, MANAGER
        else
        {
            $value = $value->clientjobs()->first();
        }

        if(!$value){
            return null;
        }

        $name = $value->name;
        $site_id = $value->site_id;
        $platform = $value->platform;
        $developer = $value->thedeveloper ? $value->thedeveloper->username : '-';
        $developer_id = $value->thedeveloper ? $value->developer_id : '-';
        $request_type = $value->therequesttype ? $value->therequesttype->name : '-';
        $request_type_id = $value->therequesttype ? $value->therequesttype->id : '-';
        $request_volume = $value->therequestvolume ? $value->therequestvolume->name : '-';
        $request_volume_id = $value->therequestvolume ? $value->therequestvolume->id : '-';
        $salesforce_link = $value->salesforce_link;
        $special_request_raw = $value->special_request;
        $special_request = $value->special_request ? 'Yes' : 'No';
        $comments_special_request = $value->comments_special_request;
        $addon_comments = $value->addon_comments;
        $agreed_sla = $value->therequestsla ? $value->therequestsla->agreed_sla : '-';
        $sla_missed = $value->sla_missed;
        $start_at = $value->start_at ? date('d-M-y h:i:s A', strtotime($value->start_at)) : '';
        $end_at = $value->end_at ? date('d-M-y h:i:s A', strtotime($value->end_at)) : '';
        $status = $value->status;

        // additional details
        $template_followed = $value->template_followed ? 'Yes' : 'No';
        $template_issue = $value->template_issue ? 'Yes' : 'No';
        $comments_template_issue = $value->comments_template_issue;
        $auto_recommend = $value->auto_recommend ? 'Yes' : 'No';
        $comments_auto_recommend = $value->comments_auto_recommend;
        $img_localstock = $value->img_localstock ? 'Yes' : 'No';
        $img_customer = $value->img_customer ? 'Yes' : 'No';
        $img_num = $value->img_num;
        $shared_folder_location = $value->shared_folder_location;
        $dev_comments = $value->dev_comments;

        // auditlogs
        $logs = [];
        $audit_logs = $value->theauditlogs ? $value->theauditlogs : '';
        foreach($audit_logs as $log) {
            $qc_round = $log->qc_round;
            $auditor = $log->theauditor ? $log->theauditor->username : '-';
            $qc_status = $log->qc_status ? $log->qc_status : '-';
            $qc_start_at = $log->start_at ? date('d-M-y h:i:s a', strtotime($log->start_at)) : '-';
            $qc_end_at = $log->end_at ? date('d-M-y h:i:s a', strtotime($log->end_at)) : '-';
            $self_qc = $log->self_qc ? 'Yes' : 'No';

            $logs[] = [
                'audit_log_id' => $log->id,
                'qc_round' => $qc_round,
                'auditor' => $auditor,
                'qc_status' => $qc_status,
                'qc_start_at' => $qc_start_at,
                'qc_end_at' => $qc_end_at,
                'self_qc' => $self_qc,
            ];
        }

        // external quality details
        $external_quality = $value->external_quality;
        $c_external_quality = $value->c_external_quality;

        $job = [
            'id' => $value->id,
            'name' => $name,
            'site_id' => $site_id,
            'platform' => $platform,
            'developer' => $developer,
            'developer_id' => $developer_id,
            'request_type' => $request_type,
            'request_type_id' => $request_type_id,
            'request_volume' => $request_volume,
            'request_volume_id' => $request_volume_id,
            'salesforce_link' => $salesforce_link,
            'special_request_raw' => $special_request_raw,
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

            // auditlogs
            'audit_logs' => $logs,

            // external quality details
            'external_quality' => $external_quality,
            'c_external_quality' => $c_external_quality,
        ];

        return $job;
    }
}
