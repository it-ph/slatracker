<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'audit_logs';
    protected $guarded = [];
    protected $dates = ['start_at','end_at','created_at', 'updated_at', 'deleted_at'];

    public function thejob()
    {
        return $this->belongsTo(Job::class, 'job_id')->withTrashed();
    }

    public function theauditor()
    {
        return $this->belongsTo(User::class, 'auditor_id')->withTrashed();
    }

    public function thecreatedby()
    {
        return $this->belongsTo(User::class, 'created_by')->withTrashed();
    }
}
