<?php

// Conexão ao banco de dados
$servidor = "154.56.48.204";
$usuario = "u400048496_brunosilva";
$senha = "Bru@1989";
$banco = "u400048496_BdAcoAdm";

header('Content-Type: application/json');

try {
    $conn = new PDO("mysql:host=$servidor;dbname=$banco", $usuario, $senha);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Prepare a consulta SQL
    $stmt = $conn->prepare("SELECT * FROM boletos");
    $stmt->execute();

    // Obtém todos os boletos como um array associativo
    $boletos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Exibe os boletos como JSON
    echo json_encode($boletos);
    
} catch (PDOException $e) {
    // Captura a exceção e exibe a mensagem de erro
    // Em um ambiente de produção, é melhor logar isso em vez de exibir o erro ao usuário
    echo json_encode(['error' => 'Erro ao recuperar boletos: ' . $e->getMessage()]);
}

// Fecha a conexão
$conn = null;

?>