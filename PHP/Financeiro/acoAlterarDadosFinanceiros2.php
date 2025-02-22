<?php
// acoBuscarTransacaoPorId.php

$servidor = "154.56.48.204";
$usuario = "u400048496_brunosilva";
$senha = "Bru@1989";
$banco = "u400048496_BdAcoAdm";

try {
    $conn = new PDO("mysql:host=$servidor;dbname=$banco", $usuario, $senha);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $idTransacao = $_GET['id'] ?? null;

    if ($idTransacao) {
        $stmt = $conn->prepare("
            SELECT t.*, m.nome AS nome_morador
            FROM transacoes_detalhadas t
            LEFT JOIN moradores m ON t.morador_id = m.id
            WHERE t.id = :id
        ");
        $stmt->bindParam(':id', $idTransacao, PDO::PARAM_INT);
        $stmt->execute();
        $transacao = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($transacao) {
            echo json_encode($transacao);
        } else {
            echo json_encode(['error' => 'Transação não encontrada.']);
        }
    } else {
        echo json_encode(['error' => 'ID da transação não fornecido.']);
    }
} catch (PDOException $e) {
    echo json_encode(['error' => 'Erro ao conectar ao banco de dados: ' . $e->getMessage()]);
}

$conn = null;
?>
