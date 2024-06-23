<?php

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
