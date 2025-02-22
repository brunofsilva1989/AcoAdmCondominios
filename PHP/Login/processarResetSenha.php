<?php
include_once __DIR__ . "/../../config/db.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $token = $_POST['token'];
    $novaSenha = password_hash($_POST['novaSenha'], PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("SELECT email FROM password_resets WHERE token = ? AND expira_em > NOW()");
    $stmt->execute([$token]);

    if ($stmt->rowCount() == 0) {
        echo json_encode(["status" => "erro", "mensagem" => "Token inválido ou expirado!"]);
        exit;
    }

    $email = $stmt->fetchColumn();
    $stmt = $pdo->prepare("UPDATE usuarios SET senha = ? WHERE email = ?");
    $stmt->execute([$novaSenha, $email]);

    echo json_encode(["status" => "sucesso", "mensagem" => "Senha redefinida com sucesso!"]);
}
?>
