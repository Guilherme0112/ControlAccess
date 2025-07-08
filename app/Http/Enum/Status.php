<?php

namespace App\Http\Enum;

enum Status: string
{
    case CADASTRADO = 'cadastrado';
    case NOTIFICADO = 'notificado';
    case APROVADO = 'aprovado';
    case ENVIADO = 'enviado';
}
