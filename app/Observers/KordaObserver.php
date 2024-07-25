<?php

namespace App\Observers;

use App\Models\Korda;

class KordaObserver
{
    public function creating(Korda $data)
    {
        $data->id = generateUuid();
    }
}
