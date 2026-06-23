<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;

    protected $fillable = [
        'site_id',
        'voucher_code',
        'profile_id',
        'status',
        'price',
        'duration_seconds',
        'generated_by',
        'created_by',
        'used_at',
        'first_login_at',
        'expires_at',
        'last_seen_at',
        'mac_address',
        'ip_address',
        'nas_ip',
        'nas_id',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'used_at' => 'datetime',
            'first_login_at' => 'datetime',
            'expires_at' => 'datetime',
            'last_seen_at' => 'datetime',
        ];
    }

    public function site()
    {
        return $this->belongsTo(Site::class);
    }

    public function profile()
    {
        return $this->belongsTo(VoucherProfile::class, 'profile_id');
    }
}