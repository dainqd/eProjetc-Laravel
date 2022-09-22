<?php

namespace App\Enums;

enum UserRole: int
{
    case Student = 100;
    case Parent = 200;
    case Teacher = 300;
    case Admin = 400;

    public function toSelectArray(): array
    {
        return [
            'Student' => self::Student,
            'Parent' => self::Parent,
            'Teacher' => self::Teacher,
            'Admin' => self::Admin,
        ];
    }
}
