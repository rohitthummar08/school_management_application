<?php

namespace App\Enums;

enum Role: string
{
    case STUDENT = 'student';
    case PARENT = 'parent';
    case TEACHER = 'teacher';
    case ADMIN = 'admin';

    public function label(): string
    {
        return ucfirst($this->value);
    }
}
