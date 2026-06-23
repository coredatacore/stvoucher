<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'voucher_id',
        'plan_id',
        'user_id',
        'amount',
        'payment_method',
        'status',
        'notes',
    ];

    public function voucher()
    {
        return $this->belongsTo(Voucher::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
