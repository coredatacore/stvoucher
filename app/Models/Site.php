<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    use HasFactory;

    protected $fillable = [
        'site_name',
        'site_code',
        'location',
        'owner_name',
        'contact_number',
        'contact_email',
        'ssid_name',
        'ddns_hostname',
        'current_public_ip',
        'notes',
        'theme',
        'status',
    ];

    public function vouchers()
    {
        return $this->hasMany(Voucher::class);
    }
}