<?php

$servidor = "154.56.48.204";
$usuario = "u400048496_brunosilva";
$senha = "Bru@1989";
$banco = "u400048496_BdAcoAdm";

$cliente_id = $_GET['cliente_id']; // Obtenha o ID do cliente da URL
$cliente = array(); // Este array armazenará os dados do cliente

try {
    $conn = new PDO("mysql:host=$servidor;dbname=$banco", $usuario, $senha);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->prepare("SELECT * FROM clientes WHERE id = :id");
    $stmt->bindParam(':id', $cliente_id);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $cliente = $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        echo "Cliente não encontrado!";
        exit;
    }

    $cliente = $stmt->fetch(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    echo "Erro: " . $e->getMessage();
}

?>
