<?php

namespace App\Models;

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
        "data_recebimento",
        "correspondencia"
    ];
}
