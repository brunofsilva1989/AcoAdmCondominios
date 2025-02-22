<?php
include_once __DIR__ . "/../../config/db.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);

    // Verificar se o e-mail existe
    $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);

    if ($stmt->rowCount() == 0) {
        echo json_encode(["status" => "erro", "mensagem" => "E-mail não encontrado!"]);
        exit;
    }

    // Gerar token seguro
    $token = bin2hex(random_bytes(32));
    $expira_em = date('Y-m-d H:i:s', strtotime('+1 hour')); // Expira em 1 hora

    // Inserir token no banco
    $stmt = $pdo->prepare("INSERT INTO password_resets (email, token, expira_em) VALUES (?, ?, ?)");
    $stmt->execute([$email, $token, $expira_em]);

    // Enviar e-mail com link de redefinição
    $link = "http://localhost/PHP/Login/resetarSenha.php?token=" . $token;
    $mensagem = "Clique no link para redefinir sua senha: " . $link;

    // Enviar e-mail (simples)
    mail($email, "Recuperação de Senha", $mensagem, "From: suporte@seusite.com");

    echo json_encode(["status" => "sucesso", "mensagem" => "E-mail de recuperação enviado!"]);
}
?>
