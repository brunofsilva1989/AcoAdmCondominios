<?php
// Substitua com o seu próprio código para conectar ao BD e buscar os dados
$servidor = "154.56.48.204";
$usuario = "u400048496_brunosilva";
$senha = "Bru@1989";
$banco = "u400048496_BdAcoAdm";

$conn = new PDO("mysql:host=$servidor;dbname=$banco", $usuario, $senha);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$stmt = $conn->prepare("SELECT * FROM ManutencoesPrediais");
$stmt->execute();
$manutencoes = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($manutencoes);
?>
