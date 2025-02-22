<?php
include_once __DIR__ . "/../../config/db.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $token = trim($_POST['token']); // Removendo espaços em branco
    $novaSenha = password_hash($_POST['novaSenha'], PASSWORD_DEFAULT);

    // Debug: Logar o token recebido
    file_put_contents('debug_reset_senha.txt', "Token recebido: " . $token . PHP_EOL, FILE_APPEND);

    // Verificar se o token existe no banco
    $stmt = $pdo->prepare("SELECT email, expira_em FROM password_resets WHERE BINARY token = ?");
    $stmt->execute([$token]);
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$resultado) {
        file_put_contents('debug_reset_senha.txt', "Token não encontrado no banco!" . PHP_EOL, FILE_APPEND);
        echo json_encode(["status" => "erro", "mensagem" => "Token inválido ou não encontrado!"]);
        exit;
    }

    // Verificar se o token está expirado
    $email = $resultado['email'];
    $expira_em = $resultado['expira_em'];

    file_put_contents('debug_reset_senha.txt', "Token encontrado para email: " . $email . ", expira em: " . $expira_em . PHP_EOL, FILE_APPEND);

    if (strtotime($expira_em) < time()) {
        file_put_contents('debug_reset_senha.txt', "Token expirado!" . PHP_EOL, FILE_APPEND);
        echo json_encode(["status" => "erro", "mensagem" => "Token expirado!"]);
        exit;
    }

    // Atualizar a senha do usuário
    $stmt = $pdo->prepare("UPDATE usuarios SET senha = ? WHERE email = ?");
    if ($stmt->execute([$novaSenha, $email])) {
        // Remover o token após redefinir a senha
        $stmt = $pdo->prepare("DELETE FROM password_resets WHERE email = ?");
        $stmt->execute([$email]);

        file_put_contents('debug_reset_senha.txt', "Senha redefinida com sucesso para: " . $email . PHP_EOL, FILE_APPEND);
        echo json_encode(["status" => "sucesso", "mensagem" => "Senha redefinida com sucesso!"]);
    } else {
        file_put_contents('debug_reset_senha.txt', "Erro ao atualizar a senha para: " . $email . PHP_EOL, FILE_APPEND);
        echo json_encode(["status" => "erro", "mensagem" => "Erro ao atualizar a senha."]);
    }
}
?>
