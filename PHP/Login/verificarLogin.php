<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(['logado' => false]);
} else {
    echo json_encode(['logado' => true]);
}


if (isset($_SESSION['tempo_login']) && (time() - $_SESSION['tempo_login'] > 1800)) {
    // Sessão expirou após 30 minutos (1800 segundos)
    session_unset(); // Limpa a sessão
    session_destroy(); // Destrói a sessão
    header("Location: login.php"); // Redireciona para a página de login
    exit;
}
$_SESSION['tempo_login'] = time(); // Atualiza o tempo de login



?>