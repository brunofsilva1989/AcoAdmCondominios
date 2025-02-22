<?php
// Conexão com o banco de dados (ajuste conforme necessário)
$servidor = "154.56.48.204";
$usuario = "u400048496_brunosilva";
$senha = "Bru@1989";
$banco = "u400048496_BdAcoAdm";

// Obter o ID da manutenção da requisição
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;


try {
    $conn = new PDO("mysql:host=$servidor;dbname=$banco", $usuario, $senha);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Preparar a consulta SQL
    $stmt = $conn->prepare("SELECT * FROM ManutencoesPrediais WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    $manutencao = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($manutencao) {
        echo json_encode(['success' => true, 'data' => $manutencao]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Nenhum dado encontrado']);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
