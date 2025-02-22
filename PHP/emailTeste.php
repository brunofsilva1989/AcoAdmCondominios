<?php
$para      = 'brunosilva@bfsilva.com.br'; // Substitua com seu e-mail real
$titulo    = 'O Teste do E-mail';
$mensagem  = 'E-mail de teste!';
$cabecalhos = 'From: brunosilva@bfsilva.com.br' . "\r\n" .  // Substitua com um e-mail do seu domínio
    'Reply-To: brunosilva@bfsilva.com.br' . "\r\n" . // Substitua com um e-mail do seu domínio
    'X-Mailer: PHP/' . phpversion();

mail($para, $titulo, $mensagem, $cabecalhos);
echo "E-mail enviado! Verifique a caixa de entrada do seu e-mail.";
?>
