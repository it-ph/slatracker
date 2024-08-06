<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UsersServices
{
    public function load()
    {
        $user = User::with('theroles:id,user_id,name')->findOrFail(auth()->user()->id);
        $roles = [];
        foreach ($user->theroles as $role) {
            array_push($roles, $role->name);
        }

        $datastorage = [];
        $users = User::with([
            'theclient:id,name',
            'theroles:id,user_id,name'
        ])
        ->select('id','username','email','client_id','status','last_login_at');

        // ADMIN
        if(in_array('admin',$roles))
        {
            $users = $users->get();
        }
        // TEAM LEAD, MANAGER
        else
        {
            $users = $users->clientusers()->get();
        }

        foreach($users as $value) {
            $username = ucwords($value->username,'.');
            $email_address = strtolower($value->email);
            $client = $value->theclient ? $value->theclient->name : "";

            $roles = [];
            foreach ($value->theroles as $role) {
                array_push($roles, $role->name);
            }
            asort($roles);
            $theroles = '';
            foreach ($roles as $role) {
                // $theroles .= !next($roles) ? $role : $role .' | ';
                $theroles .= '<span class="badge bg-primary badge-roles">'.ucwords($role).'</span> ';
            }

            $status = $value->status == 'active' ? '<span class="text-success"><strong>Active</strong></span>' : '<label class="text-danger"><strong>Deactivated</strong></label>';
            $last_login_at = $value->last_login_at ? date('d-M-y h:i:s a', strtotime($value->last_login_at)) : '-';

            $action ='<button type="button" class="btn btn-warning btn-sm waves-effect waves-light" title="Edit User" onclick=USER.show('.$value->id.')><i class="fas fa-pencil-alt"></i></button>
            <button type="button" class="btn btn-danger btn-sm waves-effect waves-light" title="Deactivate User" onclick=USER.destroy('.$value->id.')><i class="fas fa-ban"></i></button>';
            // <button type="button" class="btn btn-info btn-sm waves-effect waves-light" title="Reset Password" onclick=USER.reset_password('.$value->id.')><i class="bx bx-reset"></i></button>

            $datastorage[] = [
                'id' => $value->id,
                'username' => $username,
                'email_address' => $email_address,
                'client' => $client,
                'roles' => $theroles,
                'status' => $status,
                'last_login_at' => $last_login_at,
                'action' => $action,
            ];
        }

        return $datastorage;
    }
}
