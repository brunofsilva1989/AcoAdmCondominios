<?php

// Configuração da conexão com o banco de dados
$servidor = "154.56.48.204";
$usuario = "u400048496_brunosilva";
$senha = "Bru@1989";
$banco = "u400048496_BdAcoAdm";

// Conexão com o banco de dados
try {
    $conn = new PDO("mysql:host=$servidor;dbname=$banco", $usuario, $senha);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Query para buscar todos os boletos
    $stmt = $conn->prepare("SELECT * FROM boletos");
    $stmt->execute();

    // Recuperar os boletos como um array associativo
    $boletos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Enviar os dados em formato JSON
    echo json_encode($boletos);

} catch (PDOException $e) {
    echo "Erro ao buscar boletos: " . $e->getMessage();
}

$conn = null;
?>
