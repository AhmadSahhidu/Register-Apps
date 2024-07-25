<?php

namespace App\Observers;

use App\Models\Anggota;

class AnggotaObserver
{
    public function creating(Anggota $data)
    {
        $data->id  = generateUuid();
    }
}
