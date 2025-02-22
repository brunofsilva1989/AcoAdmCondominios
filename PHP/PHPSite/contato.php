<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = htmlspecialchars($_POST["nome"]);
    $email = htmlspecialchars($_POST["email"]);
    $mensagem = htmlspecialchars($_POST["mensagem"]);

    $to = "contato@acoadmcondominios.com.br"; // destinatário
    $subject = "Novo Contato de $nome"; // assunto
    $body = "Nome: $nome\nEmail: $email\nMensagem:\n$mensagem"; // corpo do email

    // Cabeçalhos
    $headers = "From: contato@acoadmcondominios.com.br"; // remetente

    // Enviar email
    if (mail($to, $subject, $body, $headers)) {
        echo "Mensagem enviada com sucesso!";
    } else {
        echo "Falha ao enviar a mensagem.";
    }
}
?>
