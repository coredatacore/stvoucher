<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'duration_minutes',
        'duration_hours',
        'duration_days',
        'validity_days',
        'pause_limit',
        'data_limit_mb',
        'download_speed_mbps',
        'upload_speed_mbps',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'download_speed_mbps' => 'decimal:2',
        'upload_speed_mbps' => 'decimal:2',
    ];

    public function vouchers()
    {
        return $this->hasMany(Voucher::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
