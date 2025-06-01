
# Sistema de correspondências - Athena Office

**Tecnologias:** PHP 8.2, Laravel 12  

---

## Visão Geral

Esta API foi desenvolvida com Laravel 12 e PHP 8.2.  
Possui rotas que utilizam Inertia.js para o front-end e rotas REST para a API com autenticação JWT.

---

## Estrutura de pastas

```
/app
├── Http
│   ├── Controllers
│   │   ├── AuthController.php               # Controller referente a autenticação do usuário
│   │   ├── UsuarioController.php            # Controller referente ao usuário
│   │   └── CorrespondenciaController.php    # Controller referente as correspondências
│   ├── Middleware
│   │   ├── JwtMiddleware.php                # Middleware da API
│   │   └── HandleInertiaRequests.php        # Middleware do Inertia
│   └── Requests
├── Models
│   ├── Usuario.php                          # Modelo do usuário
│   └── Correspondencia.php                  # Modelo das correspondências
├── Services
│   ├── UsuarioService.php                   # Métodos e regra de negócio do usuário
│   ├── AuthService.php                      # Métodos e regra de negócio da autenticação
│   └── CorrespondenciaService.php           # Métodos e regra de negócio das correspondências
/routes
├── api.php                                  # Rotas da API
└── web.php                                  # Rotas do Inertia
/resources
├── types                                    # Modelo para entidades do projeto
├── utils                                    # Funções que serão úteis no projeto
├── service                                  # Funções que chama o backend, referente a cada modelo          
├── js
│   ├── Pages
│   │   ├── Login.vue                        # Tela de Login (Home)
│   │   ├── AdminDashboard.vue               # Tela de dashboard do admin
│   │   └── UserDashboard.vue                # Tela de dashboard do usuario
└── views
    └── welcome.blade.php                    # Template para as views
```

---

## Rotas Inertia (Web)

| Método | Rota     | Descrição                        | Autenticação         |
|--------|----------|--------------------------------|---------------------|
| GET    | `/`      | Página inicial, formulário de login | Não requer autenticação |
| GET    | `/user`  | Dashboard do usuário            | Requer autenticação  |
| GET    | `/admin` | Dashboard do administrador     | Requer autenticação  |

---

## Rotas API (REST)

### Autenticação

| Método | Rota     | Descrição                           | Autenticação          | Entrada                   | Resposta                  |
|--------|----------|-----------------------------------|-----------------------|--------------------------|---------------------------|
| POST   | `/login` | Autenticar usuário                 | Não requer             | JSON: `{ email, senha }` | JSON: token e dados       |
| POST   | `/logout`| Encerrar sessão                   | Requer                | -                        | JSON: status              |

---

### Usuários (Somente com autenticação)

| Método | Rota            | Descrição                   | Entrada                                          | Resposta                   |
|--------|-----------------|-----------------------------|-------------------------------------------------|----------------------------|
| GET    | `/usuarios`     | Listar todos os usuários     | -                                               | JSON: lista de usuários    |
| POST   | `/usuarios`     | Criar novo usuário           | JSON: `{ nome, email, senha }`                   | JSON: usuário criado       |
| PUT    | `/usuarios/{id}`| Atualizar dados de usuário   | JSON: `{ nome?, email?, senha? }` (campos opcionais) | JSON: usuário atualizado  |
| DELETE | `/usuarios/{id}`| Deletar usuário              | -                                               | JSON: status               |

---

### Correspondências (Somente com autenticação)

| Método | Rota                | Descrição                   | Entrada                                                    | Resposta                   |
|--------|---------------------|-----------------------------|------------------------------------------------------------|----------------------------|
| GET    | `/correspondencias`  | Listar todas as correspondências | -                                                        | JSON: lista de correspondências |
| POST   | `/correspondencias`  | Criar nova correspondência  | JSON multipart/form-data: `{ nome, email_usuario, caixa_postal, unidade, status, data_recebimento, anexo }`<br>- Anexo: jpg, png, jpeg | JSON: correspondência criada |
| PUT    | `/correspondencias/{id}`| Atualizar correspondência | JSON: campos para atualizar                                | JSON: correspondência atualizada |
| DELETE | `/correspondencias/{id}`| Deletar correspondência    | -                                                          | JSON: status               |

---

## Notas importantes

- Todas as rotas protegidas requerem o envio do token JWT via cookie `auth`.
- O campo `anexo` para correspondências aceita arquivos de imagem (jpg, png, jpeg).
- Respostas de erro para autenticação inválida retornam JSON com status HTTP 401 e mensagem adequada.

---

## Exemplo de requisição para login

```bash
curl -X POST https://seu-dominio.com/api/login \
-H "Content-Type: application/json" \
-d '{"email": "usuario@exemplo.com", "senha": "123456"}'
```

Resposta esperada:

```json
{
    
    "usuario": {
        "id": 1,
        "nome": "Usuário Exemplo",
        "email": "usuario@exemplo.com"
    },
    "token": "seu-token-aqui"
}
```

---

## Contato

Em caso de dúvidas, entre em contato com a equipe de desenvolvimento.

---
