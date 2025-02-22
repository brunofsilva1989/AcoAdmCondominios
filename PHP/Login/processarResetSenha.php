<?php
include_once __DIR__ . "/../../config/db.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        // Verifica se os dados necessários foram enviados
        if (!isset($_POST['token']) || !isset($_POST['novaSenha'])) {
            throw new Exception("Token ou senha não foram enviados.");
        }

        // Captura os dados do formulário
        $token = trim($_POST['token']);
        $novaSenha = password_hash($_POST['novaSenha'], PASSWORD_DEFAULT);

        // 🚀 Debug: Mostra o token recebido no PHP
        error_log("Token recebido: " . $token);

        // 🚀 Debug: Se token estiver vazio, retorna erro
        if (empty($token)) {
            throw new Exception("Token inválido ou ausente.");
        }

        // Verificar se o token é válido e ainda não expirou
        $stmt = $pdo->prepare("SELECT email FROM password_resets WHERE BINARY token = ? AND expira_em > NOW()");
        $stmt->execute([$token]);
        
        // 🚀 Debug: Se nenhum token for encontrado, exibe erro
        if ($stmt->rowCount() == 0) {
            throw new Exception("Token inválido ou expirado.");
        }

        // Obtém o e-mail associado ao token
        $email = $stmt->fetchColumn();

        // 🚀 Debug: Se o email for NULL, algo deu errado
        if (!$email) {
            throw new Exception("Erro ao recuperar o email associado ao token.");
        }

        // 🚀 Debug: Confirma que o e-mail foi encontrado
        error_log("E-mail encontrado: " . $email);

        // Atualizar a senha do usuário na tabela `usuarios`
        $stmt = $pdo->prepare("UPDATE usuarios SET senha = ? WHERE email = ?");
        if (!$stmt->execute([$novaSenha, $email])) {
            throw new Exception("Erro ao atualizar a senha no banco de dados.");
        }

        // 🚀 Debug: Confirma que a senha foi alterada com sucesso
        error_log("Senha atualizada para o e-mail: " . $email);

        // Remover o token usado para evitar reuso
        $stmt = $pdo->prepare("DELETE FROM password_resets WHERE email = ?");
        if (!$stmt->execute([$email])) {
            throw new Exception("Erro ao remover o token do banco de dados.");
        }

        // 🚀 Debug: Confirma que o token foi removido
        error_log("Token removido para o e-mail: " . $email);

        // Retorno JSON para o AJAX
        echo json_encode(["status" => "sucesso", "mensagem" => "Senha redefinida com sucesso!"]);
        exit;

    } catch (Exception $e) {
        // Retorna erro JSON com a mensagem de erro detalhada
        echo json_encode(["status" => "erro", "mensagem" => "Erro ao redefinir senha: " . $e->getMessage()]);
        exit;
    }
}
?>
