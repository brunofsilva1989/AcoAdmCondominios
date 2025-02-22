<?php
include_once __DIR__ . "/../../config/db.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    var_dump($_POST['token']);
    $token = $_POST['token'];
    $novaSenha = password_hash($_POST['novaSenha'], PASSWORD_DEFAULT);

    // Verificar se o token é válido
    $stmt = $pdo->prepare("SELECT email FROM password_resets WHERE BINARY token = ? AND expira_em > NOW()");
    $stmt->execute([$token]);

    if ($stmt->rowCount() == 0) {
        echo json_encode(["status" => "erro", "mensagem" => "Token inválido ou expirado!"]);
        exit;
    }

    $email = $stmt->fetchColumn();

    // Atualizar a senha do usuário
    $stmt = $pdo->prepare("UPDATE usuarios SET senha = ? WHERE email = ?");
    $stmt->execute([$novaSenha, $email]);

    // Remover o token usado
    $stmt = $pdo->prepare("DELETE FROM password_resets WHERE email = ?");
    $stmt->execute([$email]);

    echo json_encode(["status" => "sucesso", "mensagem" => "Senha redefinida com sucesso!"]);
}
?>
