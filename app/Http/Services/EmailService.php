<?php

namespace App\Http\Services;

use App\Mail\UsuarioNotificacaoAnexo;
use App\Mail\UsuarioNotificacaoMail;
use App\Models\Usuario;
use Mail;

class EmailService
{

    public function sendEmailNotificacao(Usuario $usuario): void
    {
        $dados = [
            'nome' => $usuario->nome,
        ];

        Mail::to($usuario->email)->send(new UsuarioNotificacaoMail($dados));

    }
    public function sendEmailNotificacaoAnexo(Usuario $usuario): void
    {
        $dados = [
            'nome' => $usuario->nome,
        ];

        Mail::to($usuario->email)->send(new UsuarioNotificacaoAnexo($dados));

    }
}