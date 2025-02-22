<?php

session_start();
include_once __DIR__ . "/../../config/db.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    

    try {
        $nome = trim($_POST['nome']);
        $email = trim($_POST['email']);
        $senha = trim($_POST['senha']);
        $tipo = trim($_POST['tipo']);
        $cliente_id = !empty($_POST['cliente_id']) ? $_POST['cliente_id'] : NULL;
        $condominio_id = !empty($_POST['condominio_id']) ? $_POST['condominio_id'] : NULL;

        // Verificar se todos os campos obrigatórios foram preenchidos
        if (empty($nome) || empty($email) || empty($senha) || empty($tipo)) {
            echo json_encode(["status" => "erro", "mensagem" => "Todos os campos obrigatórios devem ser preenchidos!"]);
            exit;
        }

        // Verificar se o e-mail já existe
        $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);

        header('Content-Type: application/json'); // Informar que a resposta será JSON

        if ($stmt->rowCount() > 0) {
            echo json_encode(["status" => "erro", "mensagem" => "E-mail já cadastrado!"]);
            exit;
        }

        // Criptografar a senha
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

        // Preparar e executar a consulta
        $stmt = $pdo->prepare("INSERT INTO usuarios (nome, email, senha, tipo, cliente_id, condominio_id) VALUES (?, ?, ?, ?, ?, ?)");        
        $stmt->execute([$nome, $email, $senha, $tipo, $cliente_id, $condominio_id]);

        header('Content-Type: application/json'); // Informar que a resposta será JSON

        echo json_encode(["status" => "sucesso", "mensagem" => "Usuário cadastrado com sucesso!"]);
        exit;
    } catch (PDOException $e) {
        echo json_encode(["status" => "erro", "mensagem" => "Erro no banco de dados: " . $e->getMessage()]);
    }
} else {
    echo json_encode(["status" => "erro", "mensagem" => "Acesso negado!"]);
}
?>
