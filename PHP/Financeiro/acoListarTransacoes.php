<?php
$servidor = "154.56.48.204";
$usuario = "u400048496_brunosilva";
$senha = "Bru@1989";
$banco = "u400048496_BdAcoAdm";

try {
    $conn = new PDO("mysql:host=$servidor;dbname=$banco", $usuario, $senha);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $condominioId = $_GET['condominio_id6'] ?? ''; // Recebe o ID do condomínio

    if (!empty($condominioId)) {
        $stmt = $conn->prepare("
        SELECT t.*, m.nome AS nome_morador
        FROM transacoes_detalhadas t
        LEFT JOIN moradores m ON t.morador_id = m.id
        WHERE t.condominio_id = :condominio_id
        ");
        $stmt->bindParam(':condominio_id', $condominioId, PDO::PARAM_INT);
    } else {
        $stmt = $conn->prepare("
            SELECT t.*, m.nome AS nome_morador
            FROM transacoes_detalhadas t
            LEFT JOIN moradores m ON t.morador_id = m.id
        ");
    }

    $stmt->execute();
    $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $dadosTransacoes = [];
    foreach ($resultado as $transacao) {
        $linhaTransacao = [
            'id' => htmlspecialchars($transacao['id']),
            'tipo_transacao' => htmlspecialchars($transacao['tipo_transacao']),
            'condominio_id' => htmlspecialchars($transacao['condominio_id']),
            'nome_morador' => htmlspecialchars($transacao['nome_morador']),
            'categoria' => htmlspecialchars($transacao['categoria']),
            'descricao' => htmlspecialchars($transacao['descricao']),
            'valor_recebido' => htmlspecialchars($transacao['valor_recebido']),
            'valor_receber' => htmlspecialchars($transacao['valor_receber']),
            'data_transacao' => htmlspecialchars($transacao['data_transacao']),
            'status_pagamento' => htmlspecialchars($transacao['status_pagamento']),
            'data_vencimento' => htmlspecialchars($transacao['data_vencimento']),
            'data_pagamento' => htmlspecialchars($transacao['data_pagamento']),
            // Adicione aqui os botões de ação ou qualquer outra lógica necessária
            'acoes' => "<button class='btn btn-outline-primary btn-sm' onclick='editarTransacao(" . htmlspecialchars($transacao['id']) . ")'>Editar</button> " .
                       "<button class='btn btn-outline-primary btn-sm' onclick='deletarTransacao(" . htmlspecialchars($transacao['id']) . ")'>Deletar</button>"
        ];
        $dadosTransacoes[] = $linhaTransacao;
    }

    // Retorna os dados em formato JSON
    echo json_encode(['data' => $dadosTransacoes]);

} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
    echo json_encode(['error' => 'Erro ao consultar o banco de dados']);
}

$conn = null;
?>
