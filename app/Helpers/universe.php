<?php

use App\Models\Role;
use Webpatser\Uuid\Uuid;

if (!function_exists('generateUuid')) {
    /**
     * @throws Exception
     */
    function generateUuid(): string
    {
        return Uuid::generate(4)->string;
    }
}

if (!function_exists('userRoleName')) {
    /**
     * @throws Exception
     */
    function userRoleName(): string
    {
        $roleId = auth()->user()->role_id;
        $role = Role::where('id', $roleId)->first();
        return $role->name;
    }
}
