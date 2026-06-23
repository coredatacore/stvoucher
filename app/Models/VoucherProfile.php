<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VoucherProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'profile_name',
        'price',
        'duration',
        'duration_unit',
        'bandwidth_limit',
        'upload_limit',
        'download_limit',
        'max_simultaneous_use',
        'expiration_type',
        'description',
        'status',
    ];
}