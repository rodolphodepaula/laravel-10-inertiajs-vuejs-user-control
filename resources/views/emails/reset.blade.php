@component('mail::message')
# Redefinir Senha

Olá!

Você está recebendo este e-mail porque recebemos uma solicitação de redefinição de senha para sua conta.

@component('mail::button', ['url' => $url])
Redefinir Senha
@endcomponent

Este link de redefinição de senha expirará em 60 minutos.

Se você não solicitou uma redefinição de senha, nenhuma ação adicional é necessária.

Atenciosamente,<br>
{{ config('app.name') }}
@endcomponent
