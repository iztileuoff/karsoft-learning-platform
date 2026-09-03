<?php

namespace App\Enums;

enum AiMessageRole: string
{
    case User  = 'user';
    case Model = 'model';
}
