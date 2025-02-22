<?php
// acoBuscarClientePorId.php

$servidor = "154.56.48.204";
$usuario = "u400048496_brunosilva";
$senha = "Bru@1989";
$banco = "u400048496_BdAcoAdm";

try {
    $conn = new PDO("mysql:host=$servidor;dbname=$banco", $usuario, $senha);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $idCliente = $_GET['id'] ?? null;

    if ($idCliente) {
        $stmt = $conn->prepare("SELECT * FROM clientes WHERE id = :id");
        $stmt->bindParam(':id', $idCliente, PDO::PARAM_INT);
        $stmt->execute();
        $cliente = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($cliente) {
            echo json_encode($cliente);
        } else {
            echo json_encode(['error' => 'Cliente não encontrado.']);
        }
    } else {
        echo json_encode(['error' => 'ID do cliente não fornecido.']);
    }
} catch (PDOException $e) {
    echo json_encode(['error' => 'Erro ao conectar ao banco de dados: ' . $e->getMessage()]);
}

$conn = null;
?>
