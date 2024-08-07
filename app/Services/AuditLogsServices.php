<?php

namespace App\Services;

use App\Models\User;
use App\Models\AuditLog;
use Facades\App\Http\Helpers\TaskHelper;

class AuditLogsServices {

    private $roles;
    public function getRoles()
    {
        $user = User::with('theroles:id,user_id,name')->findOrFail(auth()->user()->id);
        $roles = [];
        foreach ($user->theroles as $role) {
            array_push($roles, $role->name);
        }

        return $roles;
    }

    // AUDITOR
    public function loadPendingQCs()
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
        ->orderBy('created_at','DESC');

        $roles = $this->getRoles();

        // ADMIN
        if(in_array('admin',$roles))
        {
            $pending_qcs = $pending_qcs->get();
        }
        // TEAM LEAD, MANAGER
        else
        {
            $pending_qcs = $pending_qcs->clientqcs()->get();
        }

        foreach($pending_qcs as $value) {
            $name = auth()->user()->id == $value->auditor_id ? '<a href="'.env('APP_URL').'/qualitycheck/'.$value->id.'" class="text-info">'. $value->thejob->name .'</a>' : $value->thejob->name;
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
                    '<button type="button" class="btn btn-info btn-sm waves-effect waves-light" id="btn_release_'.$value->id.'" title="Release Job" onclick=JOB.release('.$value->id.')><i class="fa fa-share"></i></button>' : '-';
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

    // QUALITY CHECK
    public function showQC($id)
    {
        $value = AuditLog::with([
            'thejob.therequestsla:id,agreed_sla',
            'thejob.therequesttype:id,name',
            'thejob.therequestvolume:id,name',
            'thejob.thedeveloper:id,username'
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
            $value = $value->clientqcs()->first();
        }

        if(!$value){
            return null;
        }

        $name = $value->thejob->name;
        $site_id = $value->thejob->site_id;
        $platform = $value->thejob->platform;
        $developer = $value->thejob->thedeveloper ? $value->thejob->thedeveloper->username : '-';
        $developer_id = $value->thejob->thedeveloper ? $value->thejob->developer_id : '-';
        $request_type = $value->thejob->therequesttype ? $value->thejob->therequesttype->name : '-';
        $request_volume = $value->thejob->therequestvolume ? $value->thejob->therequestvolume->name : '-';
        $salesforce_link = $value->thejob->salesforce_link;
        $special_request = $value->thejob->special_request ? 'Yes' : 'No';
        $comments_special_request = $value->thejob->comments_special_request;
        $addon_comments = $value->thejob->addon_comments;
        $agreed_sla = $value->thejob->therequestsla ? $value->thejob->therequestsla->agreed_sla : '-';
        $sla_missed = $value->thejob->sla_missed;
        $start_at = $value->thejob->start_at ? date('d-M-y h:i:s A', strtotime($value->thejob->start_at)) : '-';
        $end_at = $value->thejob->end_at ? date('d-M-y h:i:s A', strtotime($value->thejob->end_at)) : '-';
        $status = $value->thejob->status;

        // additional details
        $template_followed = $value->thejob->template_followed ? 'Yes' : 'No';
        $template_issue = $value->thejob->template_issue ? 'Yes' : 'No';
        $comments_template_issue = $value->thejob->comments_template_issue;
        $auto_recommend = $value->thejob->auto_recommend ? 'Yes' : 'No';
        $comments_auto_recommend = $value->thejob->comments_auto_recommend;
        $img_localstock = $value->thejob->img_localstock ? 'Yes' : 'No';
        $img_customer = $value->thejob->img_customer ? 'Yes' : 'No';
        $img_num = $value->thejob->img_num;
        $shared_folder_location = $value->thejob->shared_folder_location;
        $dev_comments = $value->thejob->dev_comments;

        // qc details
        $preview_link = $value->preview_link ? $value->preview_link : '';
        $self_qc = $value->self_qc ? 'Yes' : 'No';
        $audit_dev_comments = $value->dev_comments ? $value->dev_comments : '';
        $qc_round = $value->qc_round ? $value->qc_round : '';

        // qc feedback
        $qc_status= $value->qc_status ? $value->qc_status: null;
        $auditor_id = $value->theauditor ? $value->auditor_id : '';
        $auditor = $value->theauditor ? $value->theauditor->username : '';
        $for_rework = $value->for_rework ? 'Yes' : 'No';
        $num_times = $value->num_times;
        $alignment_aesthetics = $value->alignment_aesthetics ? 'Yes' : 'No';
        $c_alignment_aesthetics = $value->c_alignment_aesthetics ? $value->c_alignment_aesthetics : '';
        $availability_formats = $value->availability_formats ? 'Yes' : 'No';
        $c_availability_formats = $value->c_availability_formats ? $value->c_availability_formats : '';
        $accuracy = $value->accuracy ? 'Yes' : 'No';
        $c_accuracy = $value->c_accuracy ? $value->c_accuracy : '';
        $functionality = $value->functionality ? 'Yes' : 'No';
        $c_functionality = $value->c_functionality ? $value->c_functionality : '';
        $qc_comments = $value->qc_comments ? $value->qc_comments : '';
        $qc_start_at = $value->start_at ? date('d-M-y h:i:s A', strtotime($value->start_at)) : '-';
        $qc_end_at = $value->end_at ? date('d-M-y h:i:s A', strtotime($value->end_at)) : '-';

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
            'qc_round' => $qc_round,

            // qc feedback
            'auditor_id' => $auditor_id,
            'auditor' => $auditor,
            'qc_status' => $qc_status,
            'for_rework' => $for_rework,
            'num_times' => $num_times,
            'alignment_aesthetics' => $alignment_aesthetics,
            'c_alignment_aesthetics' => $c_alignment_aesthetics,
            'availability_formats' => $availability_formats,
            'c_availability_formats' => $c_availability_formats,
            'accuracy' => $accuracy,
            'c_accuracy' => $c_accuracy,
            'functionality' => $functionality,
            'c_functionality' => $c_functionality,
            'qc_comments' => $qc_comments,
            'qc_start_at' => $qc_start_at,
            'qc_end_at' => $qc_end_at,
        ];

        return $job;
    }
}
