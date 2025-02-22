<?php
header('Content-Type: application/json');

$servidor = "154.56.48.204";
$usuario = "u400048496_brunosilva";
$senha = "Bru@1989";
$banco = "u400048496_BdAcoAdm";

$conn = new PDO("mysql:host=$servidor;dbname=$banco", $usuario, $senha);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];

    try {
        $stmt = $conn->prepare("DELETE FROM ManutencoesPrediais WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $success = $stmt->execute();
        
        echo json_encode(['success' => $success]);
    } catch (PDOException $e) {
        // Retorna o erro específico do PDO
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}
?>