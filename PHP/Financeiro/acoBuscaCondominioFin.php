<?php
$servidor = "154.56.48.204";
$usuario = "u400048496_brunosilva";
$senha = "Bru@1989";
$banco = "u400048496_BdAcoAdm";

header('Content-Type: application/json');

try {
    $conn = new PDO("mysql:host=$servidor;dbname=$banco", $usuario, $senha);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->query("SELECT id, nome FROM Condominios");
    $condominios = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($condominios);
} catch (PDOException $e) {
    return "Erro: " . $e->getMessage();
}
?>