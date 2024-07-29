<?php

namespace App\Services;

use App\Models\Client;
use Illuminate\Support\Facades\Auth;

class ClientsServices
{
    public function load()
    {
        $datastorage = [];
        $clients = Client::with([
            'thecreatedby:id,username',
            'theupdatedby:id,username',
        ])
        ->get();

        foreach($clients as $value) {
            $name = $value->name;
            $created_by = $value->thecreatedby ? $value->thecreatedby->username : '-';
            $created_at = $value->created_at ? date('d-M-y h:i:s a', strtotime($value->created_at)) : '-';
            $updated_by = $value->theupdatedby ? $value->theupdatedby->username : '-';
            $updated_at = $value->updated_at ? date('d-M-y h:i:s a', strtotime($value->updated_at)) : '-';
            $action ='<button type="button" class="btn btn-warning btn-sm waves-effect waves-light" title="Edit Client" onclick=CLIENT.show('.$value->id.')><i class="fas fa-pencil-alt"></i></button>
                <button type="button" class="btn btn-danger btn-sm waves-effect waves-light" title="Delete Client" onclick=CLIENT.destroy('.$value->id.')><i class="fas fa-times"></i></button>';

            $datastorage[] = [
                'id' => $value->id,
                'name' => $name,
                'created_at' => $created_at,
                'created_by' => $created_by,
                'updated_at' => $updated_at,
                'updated_by' => $updated_by,
                'action' => $action,
            ];
        }

        return $datastorage;
    }
}
