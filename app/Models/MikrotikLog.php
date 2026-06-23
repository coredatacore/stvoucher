<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MikrotikLog extends Model
{
    protected $fillable = [
        'action',
        'request_payload',
        'response_payload',
        'status',
    ];

    protected $casts = [
        'request_payload' => 'array',
        'response_payload' => 'array',
    ];
}
