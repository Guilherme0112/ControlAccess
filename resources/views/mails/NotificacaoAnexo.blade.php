<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Notificação de envio de Anexo</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
      padding: 20px;
      color: #333;
    }
    .container {
      background-color: #ffffff;
      padding: 30px;
      border-radius: 8px;
      max-width: 600px;
      margin: auto;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    .header {
      font-size: 24px;
      font-weight: bold;
      color: #2d3748;
      margin-bottom: 20px;
    }
    .info {
      margin-bottom: 10px;
    }
    .label {
      font-weight: bold;
      color: #555;
    }
    .footer {
      margin-top: 30px;
      font-size: 14px;
      color: #888;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="header">📬 Anexo disponibilizado</div>

    <p>Olá <strong>{{ $dados['nome'] }}</strong>,</p>

    <p>Informamos que o anexo da sua correspondência foi disponibilizado para você:</p>

    <p>Favor, acesse a nossa plataforma <a href="https://www.youtube.com/watch?v=I0lA3rHbFuE&pp=ygUPdmFpIG5leW1hciBsdWxh">clicando aqui</a> e visualize o anexo.</p>

    <div class="footer">
      Esta é uma mensagem automática. Não é necessário respondê-la.
    </div>
  </div>
</body>
</html>
