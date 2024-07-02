<?php

namespace App\Observers;

use App\Models\RequestRegisterCompetision;

class RequestRegisterCompetisionObserver
{
    public function creating(RequestRegisterCompetision $data)
    {
        $data->id = generateUuid();
    }
}
