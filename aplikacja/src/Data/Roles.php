<?php
namespace App\Data;

class Roles
{
    public static function getRoles()
    {
        return [
            'ROLE_ADMIN' => 'ROLE_ADMIN',
            'ROLE_USER' => 'ROLE_USER'
        ];
    }
}