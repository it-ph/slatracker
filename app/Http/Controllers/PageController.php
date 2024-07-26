<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Client;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\GlobalVariableController;

class PageController extends GlobalVariableController
{
    private $credentials;
    public function __construct()
    {
        parent::__construct();
    }

    /** Getter and Setter */
    public function setCredentials()
    {
        $user = User::with('theroles:id,user_id,name')->findOrFail(auth()->user()->id);
        $roles = [];
        foreach ($user->theroles as $role) {
            array_push($roles, $role->name);
        }

        $theroles = '';
        foreach ($roles as $role) {
            $theroles .= !next($roles) ? $role : $role .' | ';
        }

        $userdata = [
                'id'        => $user->id,
                'username'  => ucwords($user->username,'.'),
                'email'  => strtolower($user->email),
                'roles'     => $roles,
                'theroles' => ucwords($theroles)
        ];
        $this->credentials = $userdata;
    }

    public function getCredentials()
    {
        return $this->credentials;
    }

    /** Home */
    public function showHome()
    {
        $this->setCredentials();
        $user = $this->getCredentials();

        return view('index', compact('user'));
    }

    /** Add Job */
    public function addJob()
    {
        $this->setCredentials();
        $user = $this->getCredentials();

        return view('pages.admin.jobs.create', compact('user'));
    }

    /** Users */
    public function showUsers(Request $request)
    {
        $this->setCredentials();
        $user = $this->getCredentials();

        return view('pages.admin.users.list', compact('user'));
    }

    /** Clients */
    public function showClients()
    {
        $this->setCredentials();
        $user = $this->getCredentials();


        return view('pages.admin.clients.list', compact('user'));
    }

    /** Request Types */
    public function showRequestTypes()
    {
        $this->setCredentials();
        $user = $this->getCredentials();

        return view('pages.admin.request-types.list', compact('user'));
    }

    /** Request Volumes */
    public function showRequestVolumes()
    {
        $this->setCredentials();
        $user = $this->getCredentials();

        return view('pages.admin.request-volumes.list', compact('user'));
    }

    /** Request SLAs */
    public function showRequestSLAs()
    {
        $this->setCredentials();
        $user = $this->getCredentials();

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
