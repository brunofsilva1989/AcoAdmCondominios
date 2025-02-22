<?php
$servidor = "154.56.48.204";
$usuario = "u400048496_brunosilva";
$senha = "Bru@1989";
$banco = "u400048496_BdAcoAdm";

header('Content-Type: application/json');

try {
    $conn = new PDO("mysql:host=$servidor;dbname=$banco", $usuario, $senha);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Coleta dos dados enviados via POST
    $id = $_POST['id'];
    $tipo_transacao = $_POST['tipo_transacao'];
    $nomeMorador = $_POST['nome_morador']; // Alterado para usar o nome do morador
    $categoria = $_POST['categoria'];
    $descricao = $_POST['descricao'];
    $valor_recebido = $_POST['valor_recebido'];
    $valor_receber = $_POST['valor_receber'];
    $data_transacao = $_POST['data_transacao'];
    $status_pagamento = $_POST['status_pagamento'];
    $data_vencimento = $_POST['data_vencimento'];
    $data_pagamento = $_POST['data_pagamento'];

    // Primeiro, encontre o ID do morador pelo nome
    $stmt = $conn->prepare("SELECT id FROM moradores WHERE nome = :nome");
    $stmt->bindParam(':nome', $nomeMorador);
    $stmt->execute();
    $morador = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($morador) {
        $moradorId = $morador['id'];

        // Agora atualize a transação com o ID do morador
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

        $stmt->bindParam(':id', $id);
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

        if ($stmt->rowCount() > 0) {
            echo json_encode(['success' => 'Dados da transação atualizados com sucesso.']);
        } else {
            echo json_encode(['warning' => 'Nenhum dado foi alterado.']);
        }
    } else {
        echo json_encode(['error' => 'Morador não encontrado.']);
    }
} catch (PDOException $e) {
    echo json_encode(['error' => 'Erro ao atualizar os dados da transação: ' . $e->getMessage()]);
}

$conn = null;
?>