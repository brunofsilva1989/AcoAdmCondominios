<?php
$servidor = "154.56.48.204";
$usuario = "u400048496_brunosilva";
$senha = "Bru@1989";
$banco = "u400048496_BdAcoAdm";

header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");

try {
    $conn = new PDO("mysql:host=$servidor;dbname=$banco", $usuario, $senha);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

    $stmt = $conn->prepare("SELECT * FROM Condominios WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    $condominio = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($condominio) {
        echo json_encode(['success' => true, 'data' => $condominio]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Condomínio não encontrado']);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Erro: ' . $e->getMessage()]);
}
   

$conn = null;
?>
