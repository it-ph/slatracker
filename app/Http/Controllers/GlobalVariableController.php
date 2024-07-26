<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Client;
use Illuminate\Support\Facades\View;

class GlobalVariableController extends Controller
{
    public $clients,$users,$permissions,$tls,$oms;

    public function __construct()
    {
        $this->clients = Client::query()
            ->select('id','name')
            ->orderBy('name', 'ASC')
            ->get();

        $this->users = User::query()
            ->select('id','username','email')
            ->where('status','active')
            ->orderBy('email', 'ASC')
            ->get();

        View::share('clients', $this->clients);
        View::share('users', $this->users);
    }
}
