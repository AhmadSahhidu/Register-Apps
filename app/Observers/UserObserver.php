<?php

namespace App\Observers;

use App\Models\User;

class UserObserver
{

    public function create(User $data)
    {
        $data->id = generateUuid();
    }
}
