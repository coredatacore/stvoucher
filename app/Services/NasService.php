<?php

namespace App\Services;

use App\Models\Nas;
use Illuminate\Support\Facades\Crypt;

class NasService
{
    public function createNas(array $data)
    {
        return Nas::create([
            'nasname' => $data['nasname'],
            'shortname' => $data['shortname'],
            'type' => $data['type'],
            'ports' => $data['ports'] ?? null,
            'secret' => $data['secret'], // FreeRADIUS requires plaintext secret in DB
            'server' => $data['server'] ?? null,
            'community' => $data['community'] ?? null,
            'description' => $data['description'] ?? null,
        ]);
    }
}