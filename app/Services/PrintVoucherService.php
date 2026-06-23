<?php

namespace App\Services;

class PrintVoucherService
{
    public function getLayoutData(iterable $vouchers, string $layoutType)
    {
        // Define items per page based on layout
        $itemsPerPage = match ($layoutType) {
            '15_per_page' => 15,
            '20_per_page' => 20,
            '30_per_page' => 30,
            default => 20,
        };

        return [
            'vouchers' => $vouchers,
            'itemsPerPage' => $itemsPerPage,
            'layout' => $layoutType
        ];
    }
}