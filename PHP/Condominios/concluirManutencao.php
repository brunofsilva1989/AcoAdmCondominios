<?php
header('Content-Type: application/json');

$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

$servidor = "154.56.48.204";
$usuario = "u400048496_brunosilva";
$senha = "Bru@1989";
$banco = "u400048496_BdAcoAdm";

try {
    $conn = new PDO("mysql:host=$servidor;dbname=$banco", $usuario, $senha);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Supondo que você está movendo os dados para uma tabela de histórico
    // E excluindo o registro da tabela original

    // Inserir o registro na tabela de histórico (ajuste conforme necessário)
    $stmt = $conn->prepare("INSERT INTO HistoricoManutencoes SELECT * FROM ManutencoesPrediais WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    // Excluir o registro da tabela original
    $stmt = $conn->prepare("DELETE FROM ManutencoesPrediais WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    echo json_encode(['success' => true, 'message' => 'Manutenção concluída e movida para o histórico!']);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Erro: ' . $e->getMessage()]);
}

?>
