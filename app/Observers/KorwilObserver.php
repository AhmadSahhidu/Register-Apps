<?php

namespace App\Observers;

use App\Models\Korwil;

class KorwilObserver
{
    public function creating(Korwil $data)
    {
        $data->id = generateUuid();
    }
}
