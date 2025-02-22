<?php

session_start();
//caminho do arquivo de conexão com o banco de dados
include_once __DIR__ . "/../../config/db.php";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    try {
        // Preparar a consulta SQL
        $stmt = $pdo->prepare("SELECT id, senha, tipo, condominio_id FROM usuarios WHERE email = ?");
        $stmt->bindParam(1, $email, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            if (password_verify($senha, $usuario['senha'])) {
                $_SESSION['usuario_id'] = $usuario['id'];
                $_SESSION['tipo_usuario'] = $usuario['tipo'];
                $_SESSION['condominio_id'] = $usuario['condominio_id'];                
                echo "Login bem-sucedido";
            } else {
                echo "Senha incorreta!";
            }
        } else {
            echo "Usuário não encontrado!";
        }
    } catch (PDOException $e) {
        echo "Erro no banco de dados: " . $e->getMessage();
    }
}
?>
