<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Task;
use App\Models\User;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Facades\App\Http\Helpers\CredentialsHelper;
use App\Http\Controllers\GlobalVariableController;

class PageController extends GlobalVariableController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function thecredentials()
    {
        return CredentialsHelper::get_set_credentials();
    }

    public function thedevelopers()
    {
        return CredentialsHelper::get_developers();
    }

    public function thedevs()
    {
        return CredentialsHelper::get_devs();
    }

    public function theauditors()
    {
        return CredentialsHelper::get_auditors();
    }

    /** Home */
    public function showHome()
    {
        $user = $this->thecredentials();
        $developers = $this->thedevelopers();
        return view('pages.dashboard.index', compact('user','developers'));
    }

    /** Add Job */
    public function addJob()
    {
        $user = $this->thecredentials();
        $developers = $this->thedevelopers();
        return view('pages.admin.jobs.create', compact('user','developers'));
    }

    /** Pending Jobs */
    public function showPendingJobs()
    {
        $user = $this->thecredentials();
        return view('pages.admin.jobs.pending', compact('user'));
    }

    /** Jobs */
    public function showJobs()
    {
        $user = $this->thecredentials();
        return view('pages.admin.jobs.all', compact('user'));
    }

    /** My Jobs */
    public function showMyJobs()
    {
        $user = $this->thecredentials();
        return view('pages.dev.jobs.list', compact('user'));
    }

    /** Quality Check */
    public function showPendingQC()
    {
        $user = $this->thecredentials();
        return view('pages.auditor.jobs.list', compact('user'));
    }

    /** Reallocate Job */
    public function showReallocateJob()
    {
        $user = $this->thecredentials();
        $developers = $this->thedevelopers();
        return view('pages.admin.reallocation.job.list', compact('user','developers'));
    }

    /** Reallocate QC */
    public function showReallocateQC()
    {
        $user = $this->thecredentials();
        $auditors = $this->theauditors();
        return view('pages.admin.reallocation.qc.list', compact('user','auditors'));
    }

    /** Users */
    public function showUsers(Request $request)
    {
        $user = $this->thecredentials();
        return view('pages.admin.users.list', compact('user'));
    }

    /** JobLogReports */
    public function showJobLogReports(Request $request)
    {
        $user = $this->thecredentials();
        $developers = $this->thedevs();
        return view('pages.admin.reports.job-log.index', compact('user','developers'));
    }

    /** AuditLogReports */
    public function showAuditLogReports(Request $request)
    {
        $user = $this->thecredentials();
        $auditors = $this->theauditors();
        return view('pages.admin.reports.audit-log.index', compact('user','auditors'));
    }

    /** DevReports */
    public function showDevReports(Request $request)
    {
        $user = $this->thecredentials();
        $developers = $this->thedevs();
        return view('pages.admin.reports.dev.index', compact('user','developers'));
    }

    /** Configuration */
    public function showConfiguration()
    {
        $user = $this->thecredentials();
        $email_config = Client::query()
            ->where('id', auth()->user()->client_id)
            ->select('id','name','sla_threshold','sla_threshold_to','sla_threshold_cc','sla_missed_to','sla_missed_cc','new_job_cc','qc_send_cc','daily_report_to','daily_report_cc')
            ->first();
        return view('pages.admin.configs.index', compact('user','email_config'));
    }

    /** Clients */
    public function showClients()
    {
        $user = $this->thecredentials();
        return view('pages.admin.clients.list', compact('user'));
    }

    /** Request Types */
    public function showRequestTypes()
    {
        $user = $this->thecredentials();
        return view('pages.admin.request-types.list', compact('user'));
    }

    /** Request Volumes */
    public function showRequestVolumes()
    {
        $user = $this->thecredentials();
        return view('pages.admin.request-volumes.list', compact('user'));
    }

    /** Request SLAs */
    public function showRequestSLAs()
    {
        $user = $this->thecredentials();
        return view('pages.admin.request-slas.list', compact('user'));
    }








    // ADMIN, TL, & OM ACCESS
    public function showAgentTaskLists(Request $request)
    {
        // accountant
        if(Auth::user()->isAccountant())
        {
            return redirect()->route('unauthorized');
        }

        $status = $request['status'];
        if(!in_array(strtolower($status),['','all','in progress','on hold','completed']))
        {
            return view('errors.404');
        }

        return view('pages.admin.tasks.list');
    }

    // AGENT ACCESS
    public function showAgentTasks(Request $request)
    {
        $status = $request['status'];
        if(!in_array(strtolower($status),['','all','in progress','on hold','completed']))
        {
            return view('errors.404');
        }
        $clients = Auth::user()->isAdmin() ? $clients = Client::with('thecluster')->get() : Client::with('thecluster')->cluster()->get();

        $user_client_activities = ClientActivity::query()
            ->select('id','agent_id','name')
            ->where('agent_id', Auth::user()->emp_id)
            ->orderBy('name', 'ASC')
            ->get();

        return view('pages.agent.tasks.list', compact('status','clients','user_client_activities'));
    }

    /**
     * Task Lists
     */
    public function AgentTasks(Request $request)
    {
        $status = $request['status'];

        // accountant
        if(Auth::user()->isAccountant())
        {
            return redirect()->route('unauthorized');
        }

        $status = $request['status'];
        if(!in_array(strtolower($status),['all','in progress','on hold','completed']))
        {
            return view('errors.404');
        }
        $clients = Auth::user()->isAdmin() ? $clients = Client::with('thecluster') : Client::with('thecluster')->cluster()->get();

        $user_client_activities = ClientActivity::query()
            ->select('id','agent_id','name')
            ->orderBy('name', 'ASC')
            ->get();

        return view('pages.admin.tasks.list', compact('status'));
    }
}
