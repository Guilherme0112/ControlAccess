<?php

namespace App\Http\Services;

use App\Mail\UsuarioNotificacaoMail;
use App\Models\Usuario;
use Mail;

class EmailService
{

    public function sendEmail(Usuario $usuario): void
    {
        $dados = [
            'nome' => $usuario->nome,
        ];

        Mail::to($usuario->email)->send(new UsuarioNotificacaoMail($dados));

    }
}