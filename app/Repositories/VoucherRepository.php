<?php

namespace App\Repositories;

use App\Models\Voucher;

class VoucherRepository extends BaseRepository
{
    public function __construct(Voucher $model)
    {
        parent::__construct($model);
    }

    public function findByCode(string $code): ?Voucher
    {
        return $this->model->where('code', $code)->first();
    }
}
