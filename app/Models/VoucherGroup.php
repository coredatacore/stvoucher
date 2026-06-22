<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VoucherGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'site_id',
        'group_name',
        'batch_code',
        'voucher_profile_id',
        'quantity',
        'prefix',
        'generated_by',
        'status',
    ];

    public function site()
    {
        return $this->belongsTo(Site::class);
    }

    public function profile()
    {
        return $this->belongsTo(VoucherProfile::class, 'voucher_profile_id');
    }

    public function vouchers()
    {
        return $this->hasMany(Voucher::class);
    }
}