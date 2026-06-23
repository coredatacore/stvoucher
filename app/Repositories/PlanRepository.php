<?php

namespace App\Repositories;

use App\Models\Plan;

class PlanRepository extends BaseRepository
{
    public function __construct(Plan $model)
    {
        parent::__construct($model);
    }

    public function getActivePlans()
    {
        return $this->model->where('is_active', true)->get();
    }
}
