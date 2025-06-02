<?php

namespace App\Http\Enum;

enum Status: string
{
    case CADASTRADO = 'cadastrado';
    case NOTIFICADO = 'notificado';
    case ENVIADO = 'enviado';
}
