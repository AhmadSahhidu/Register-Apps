<?php

namespace App\Observers;

use App\Models\Korwil;

class KorwilObserver
{
    public function create(Korwil $data)
    {
        $data->id = generateUuid();
    }
}
