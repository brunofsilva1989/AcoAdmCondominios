<?php
$id = $_GET['id'];

$servidor = "31.170.167.102";
$usuario = "u682077517_brunosilva";
$senha = "Bru@1989";
$banco = "u682077517_acodb";


$conn = new PDO("mysql:host=$servidor;dbname=$banco", $usuario, $senha);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


try {
    $sql = "DELETE FROM Condominios WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    header("Location: .../acoCadastrarCondominio.html"); // Redireciona de volta para a página da tabela
} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}
