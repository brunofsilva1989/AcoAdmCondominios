<?php
$servidor = "154.56.48.204";
$usuario = "u400048496_brunosilva";
$senha = "Bru@1989";
$banco = "u400048496_BdAcoAdm";

header('Content-Type: application/json');

try {
    $conn = new PDO("mysql:host=$servidor;dbname=$banco", $usuario, $senha);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Substitua pelos campos da tabela transacoes_detalhadas
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    $tipo_transacao = filter_input(INPUT_POST, 'tipo_transacao', FILTER_SANITIZE_STRING);
    $nome_morador = filter_input(INPUT_POST, 'nome_morador', FILTER_SANITIZE_STRING);
    $categoria = filter_input(INPUT_POST, 'categoria', FILTER_SANITIZE_STRING);
    $descricao = filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_STRING);
    $valor_recebido = filter_input(INPUT_POST, 'valor_recebido', FILTER_SANITIZE_STRING);
    $valor_receber = filter_input(INPUT_POST, 'valor_receber', FILTER_SANITIZE_STRING);
    $data_transacao = filter_input(INPUT_POST, 'data_transacao', FILTER_SANITIZE_STRING);
    $status_pagamento = filter_input(INPUT_POST, 'status_pagamento', FILTER_SANITIZE_STRING);
    $data_vencimento = filter_input(INPUT_POST, 'data_vencimento', FILTER_SANITIZE_STRING);
    $data_pagamento = filter_input(INPUT_POST, 'data_pagamento', FILTER_SANITIZE_STRING);


    $stmt = $conn->prepare("SELECT id FROM moradores WHERE nome = :nome");
    $stmt->bindParam(':nome', $_POST['nome_morador']);
    $stmt->execute();
    $morador = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($morador) {
        $moradorId = $morador['id'];
    }

    // Prepare a query de atualização
    $stmt = $conn->prepare("UPDATE transacoes_detalhadas SET 
    tipo_transacao = :tipo_transacao,         
    morador_id = :morador_id,
    categoria = :categoria,
    descricao = :descricao,
    valor_recebido = :valor_recebido,
    valor_receber = :valor_receber,
    data_transacao = :data_transacao,
    status_pagamento = :status_pagamento,
    data_vencimento = :data_vencimento,
    data_pagamento = :data_pagamento
    WHERE id = :id");

    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->bindParam(':tipo_transacao', $tipo_transacao);
    $stmt->bindParam(':morador_id', $moradorId);
    $stmt->bindParam(':categoria', $categoria);
    $stmt->bindParam(':descricao', $descricao);
    $stmt->bindParam(':valor_recebido', $valor_recebido);
    $stmt->bindParam(':valor_receber', $valor_receber);
    $stmt->bindParam(':data_transacao', $data_transacao);
    $stmt->bindParam(':status_pagamento', $status_pagamento);
    $stmt->bindParam(':data_vencimento', $data_vencimento);
    $stmt->bindParam(':data_pagamento', $data_pagamento);


    $stmt->execute();

    if ($stmt->rowCount()) {
        echo json_encode(['success' => true, 'message' => 'Transação atualizada com sucesso']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Nenhuma alteração realizada']);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Erro: ' . $e->getMessage()]);
}

$conn = null;
