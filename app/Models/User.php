<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use SoftDeletes;
    use Notifiable;

    protected $table = 'users';
    protected $dates = ['two_factor_expires_at','deleted_at','created_at','updated_at','last_login_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function scopeClients($query)
    {
        return $query->where('client_id',auth()->user()->client_id);
    }

    public function theclient()
    {
        return $this->belongsTo(Client::class, 'client_id')->withTrashed();
    }

    public function theroles()
    {
        return $this->hasMany(Role::class,'user_id');
    }

    public function isStatusActive()
    {
        $isActive = $this->status == 'active'? true : false;
        return $isActive;
    }

    public function hasActiveTask()
    {
        $hasActiveTask = Task::query()
            ->where('agent_id', $this->id)
            ->where('status', 'In Progress')
            ->count();

        $hasActiveTask = $hasActiveTask ? true : false;

        return $hasActiveTask;
    }

    /**
     *  START OF USER ROLES
     */

    // accountant
    // public function isAccountant()
    // {
    //     $role = 'accountant';
    //     $hasRole = User::query()
    //         ->whereIn('role',[
    //             $role
    //         ])
    //         ->where('id',$this->id)
    //         ->first();

    //     if($hasRole)
    //     {
    //         return true;
    //     }

    //     return false;
    // }

    // // admin
    // public function isAdmin()
    // {
    //     $role = 'admin';
    //     $hasRole = User::query()
    //         ->whereIn('role',[
    //             'superadmin',
    //             $role
    //         ])
    //         ->where('id',$this->id)
    //         ->first();

    //     if($hasRole)
    //     {
    //         return true;
    //     }

    //     return false;
    // }

    // // Team Leader
    // public function isTeamLeader()
    // {
    //     $role = 'team leader';
    //     $hasRole = User::query()
    //         ->whereIn('role',[
    //             'superadmin',
    //             $role
    //         ])
    //         ->where('id',$this->id)
    //         ->first();

    //     if($hasRole)
    //     {
    //         return true;
    //     }

    //     return false;
    // }

    // // Manager
    // public function isManager()
    // {
    //     $role = 'manager';
    //     $hasRole = User::query()
    //         ->whereIn('role',[
    //             'superadmin',
    //             $role
    //         ])
    //         ->where('id',$this->id)
    //         ->first();

    //     if($hasRole)
    //     {
    //         return true;
    //     }

    //     return false;
    // }

    // // admin or team leader
    // public function isTeamLeaderOrAdmin()
    // {
    //     $role = 'team leader';
    //     $hasRole = User::query()
    //         ->whereIn('role',[
    //             'superadmin',
    //             'admin',
    //             $role
    //         ])
    //         ->where('id',$this->id)
    //         ->first();

    //     if($hasRole)
    //     {
    //         return true;
    //     }

    //     return false;
    // }

    // // admin or manager
    // public function isManagerOrAdmin()
    // {
    //     $role = 'manager';
    //     $hasRole = User::query()
    //         ->whereIn('role',[
    //             'superadmin',
    //             'admin',
    //             $role
    //         ])
    //         ->where('id',$this->id)
    //         ->first();

    //     if($hasRole)
    //     {
    //         return true;
    //     }

    //     return false;
    // }

    // // admin, team leader or manager
    // public function isTLOMOrAdmin()
    // {
    //     $tl = 'team leader';
    //     $om = 'manager';
    //     $hasRole = User::query()
    //         ->whereIn('role',[
    //             'superadmin',
    //             'admin',
    //             $tl,
    //             $om
    //         ])
    //         ->where('id',$this->id)
    //         ->first();

    //     if($hasRole)
    //     {
    //         return true;
    //     }

    //     return false;
    // }

    /**
     * END OF USER ROLES
     */


    /**
     * Generate 6 digits MFA code for the User
     */
    public function generateTwoFactorCode()
    {
        $this->timestamps = false; //Dont update the 'updated_at' field yet
        $this->two_factor_code = rand(100000, 999999);
        $this->two_factor_expires_at = now()->addMinutes(10);
        $this->save();
    }

    /**
     * Reset the MFA code generated earlier
     */
    public function resetTwoFactorCode()
    {
        $this->timestamps = false; //Dont update the 'updated_at' field yet
        $this->two_factor_code = null;
        $this->two_factor_expires_at = null;
        $this->save();
    }

    public function is2FApassed()
    {
        $user = User::where('email', Auth::user()->email)->first();

        if($user->two_factor_code == NULL && $user->two_factor_expires_at == NULL)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}
