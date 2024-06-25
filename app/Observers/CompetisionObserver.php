<?php

namespace App\Observers;

use App\Models\Competision;

class CompetisionObserver
{
    public function creating(Competision $data)
    {
        $data->id = generateUuid();
    }
}
