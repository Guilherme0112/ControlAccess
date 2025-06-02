<?php

namespace App\Models;

use App\Http\Enum\Status;
use Illuminate\Database\Eloquent\Model;

class Correspondencia extends Model
{
    protected $fillable = [
        "id",
        "nome",
        "email_usuario",
        "caixa_postal",
        "unidade",
        "status",
        "remetente",
        "data_recebimento",
        "correspondencia"
    ];

    protected $casts = [
        'status' => Status::class,
        'data_recebimento' => 'datetime',
    ];
}
