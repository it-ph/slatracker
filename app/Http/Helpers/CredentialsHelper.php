<?php

namespace App\Http\Helpers;

use App\Models\User;

class CredentialsHelper {
    private $credentials;

    /** Getter and Setter */
    public function setCredentials()
    {
        $user = User::with([
            'theroles:id,user_id,name',
            'theclient:id,name'
        ])->findOrFail(auth()->user()->id);
        $roles = [];
        foreach ($user->theroles as $role) {
            array_push($roles, $role->name);
        }
        asort($roles);
        $theroles = '';
        foreach ($roles as $role) {
            $theroles .= !next($roles) ? $role : $role .' | ';
        }

        $userdata = [
                'id'        => $user->id,
                'username'  => ucwords($user->username,'.'),
                'email'  => strtolower($user->email),
                'roles'     => $roles,
                'client'     => $user->theclient->name,
                'theroles' => ucwords($theroles)
        ];
        $this->credentials = $userdata;
    }

    public function getCredentials()
    {
        return $this->credentials;
    }

    public function get_set_credentials()
    {
        $this->setCredentials();
        $user = $this->getCredentials();

        return $user;
    }

    public function get_developers()
    {
        $developers = User::query()
            ->whereHas('theroles', function ($query) {
                $query->where('name', 'Developer');
            })
            ->developers()
            ->isactive()
            ->select('id','username','email','client_id','last_login_at','status')
            ->orderBy('email','asc')
            ->get();

        return $developers;
    }
}
