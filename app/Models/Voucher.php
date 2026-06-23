<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    protected $fillable = [
        'code',
        'username',
        'password',
        'mac_address',
        'plan_id',
        'router_server_id',
        'mikrotik_user_id',
        'created_by',
        'status',
        'activated_at',
        'expires_at',
        'valid_until',
        'paused_at',
        'remaining_seconds_when_paused',
        'pause_count',
        'data_used_mb',
    ];

    protected $casts = [
        'activated_at' => 'datetime',
        'expires_at' => 'datetime',
        'valid_until' => 'datetime',
        'paused_at' => 'datetime',
    ];

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function routerServer()
    {
        return $this->belongsTo(RouterServer::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function voucherLogs()
    {
        return $this->hasMany(VoucherLog::class);
    }

    public function transaction()
    {
        return $this->hasOne(Transaction::class);
    }

    public function mikrotikLogs()
    {
        return $this->hasMany(MikrotikLog::class);
    }
}
