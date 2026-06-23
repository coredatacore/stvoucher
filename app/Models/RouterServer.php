<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RouterServer extends Model
{
    protected $fillable = [
        'name',
        'ip_address',
        'api_port',
        'api_username',
        'api_password',
        'is_active',
        'last_connected_at',
        'last_error',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'last_connected_at' => 'datetime',
    ];

    public function vouchers()
    {
        return $this->hasMany(Voucher::class);
    }
}
