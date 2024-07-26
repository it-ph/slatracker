<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\ResponseTraits;
use App\Services\UsersServices;
use Illuminate\Support\Facades\Hash;
use App\Notifications\AccountCreated;
use App\Http\Requests\UserStoreRequest;
use App\Http\Controllers\GlobalVariableController;

class UserController extends GlobalVariableController
{
    use ResponseTraits;

    public function __construct()
    {
        parent::__construct();
        $this->service = new UsersServices();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result = $this->successResponse('Users loaded successfully!');
        try
        {
            $result["data"] =  $this->service->load();
        } catch (\Throwable $th)
        {
            return $this->errorResponse($th);
        }

        return $this->returnResponse($result);
    }

    public function store(UserStoreRequest $request)
    {
        $result = $this->successResponse('User created successfully!');
        try{
            if($request->edit_id === null)
            {
                $password = $this->generatePassword();
                $request['password'] = Hash::make($password);

                $data = [
                    'username'  => $request->username,
                    'email'     => $request->email,
                    'client_id' => $request->client_id,
                    'password'  => $request->password,
                    'status'    => $request->status
                ];

                $validate = User::withTrashed()->where('email',$request->email)->first();
                if (!empty($validate)) {
                    $result = $this->restore($request->email);
                    $user = User::updateOrCreate(
                        [
                            'email' => $request->email,
                        ],
                        $data
                    );
                    // send username and password
                    $user->notify(new AccountCreated($password));
                }
                else
                {
                    $user = User::updateOrCreate(
                        [
                            'email' => $request->email,
                        ],
                        [
                            'client_id' => $request->client_id,
                            'status' => $request->status
                        ]
                    );

                    // send username and password
                    if($user->wasRecentlyCreated)
                    {
                        $user->notify(new AccountCreated($password));
                    }
                }

                // delete then create new roles
                Role::where('user_id',$user->id)->delete();
                if ($user) {
                    $role = [];
                    for ($i = 0; $i < count($request->roles); $i++) {
                        $role = [
                            'user_id' => $user->id,
                            'name' => $request->roles[$i],
                        ];
                        Role::create($role);
                    }
                }
            }
            else
            {
                // delete then create new roles
                Role::where('user_id',$request->edit_id)->delete();

                $role = [];
                for ($i = 0; $i < count($request->roles); $i++) {
                    $role = [
                        'user_id' => $request->edit_id,
                        'name'    => $request->roles[$i],
                    ];
                    Role::create($role);
                }
                $result = $this->update(
                    [
                    'username'  => $request->username,
                    'email'     => $request->email,
                    'client_id' => $request->client_id,
                    'password'  => $request->password,
                    'status'    => $request->status
                ]
                    , $request->edit_id);
            }
        } catch (\Throwable $th) {
            return $this->errorResponse($th);
        }

        return $this->returnResponse($result);
    }

    public function show($id)
    {
        $result = $this->successResponse('User retrieved successfully!');
        try {
            $result["data"] = User::with('theroles:user_id,name')->findOrfail($id);
        } catch (\Throwable $th) {
            return $this->errorResponse($th);
        }

        return $this->returnResponse($result);
    }

    public function update($data, $id)
    {
        $result = $this->successResponse('User updated successfully!');
        try {
            $data = [
                'username'  => $data['username'],
                'email'     => $data['email'],
                'client_id' => $data['client_id'],
                'status'    => $data['status'],
            ];
            User::findOrFail($id)->update($data);

        } catch (\Throwable $th)
        {
            $result = $this->errorResponse($th);
        }

        return $result;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $User
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrfail($id);
        $result = $this->successResponse('User deleted successfully!');
        try {
            $user->delete();
        } catch (\Throwable $th)
        {
            return $this->errorResponse($th);
        }

        return $this->returnResponse($result);
    }

    private function restore($email)
    {
        $result = $this->successResponse('User Successfully Restored');
        try {
            User::where('email',$email)->restore();
        } catch (\Throwable $th) {
            $result = $this->errorResponse($th);
        }

        return $result;
    }


    public function generatePassword($length = 8) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
        $password = substr( str_shuffle( $chars ), 0, $length );
        return $password;
    }
}
