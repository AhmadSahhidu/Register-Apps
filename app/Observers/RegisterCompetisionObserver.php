<?php

namespace App\Observers;

use App\Models\RegisterCompetision;

class RegisterCompetisionObserver
{
    public function creating(RegisterCompetision $data)
    {
        $data->id = generateUuid();
    }
}
