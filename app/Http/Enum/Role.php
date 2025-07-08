<?php 

namespace App\Http\Enum;

enum Role: string
{
    case ADMIN = 'admin';
    case CLIENTE = 'cliente';
}