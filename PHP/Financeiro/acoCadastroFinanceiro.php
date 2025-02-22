<?php
$servidor = "154.56.48.204";
$usuario = "u400048496_brunosilva";
$senha = "Bru@1989";
$banco = "u400048496_BdAcoAdm";

try {
    $conn = new PDO("mysql:host=$servidor;dbname=$banco", $usuario, $senha);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        // Adicione isto para verificar os dados recebidos
        echo '<pre>';
        var_dump($_POST);
        echo '</pre>';

        $stmt = $conn->prepare("INSERT INTO transacoes_detalhadas (tipo_transacao, condominio_id, morador_id, categoria, descricao, valor_recebido, valor_receber, data_transacao, status_pagamento,  data_vencimento, data_pagamento) VALUES (:tipo_transacao, :condominio_id, :morador_id, :categoria, :descricao, :valor_recebido, :valor_receber, :data_transacao, :status_pagamento, :data_vencimento, :data_pagamento)");

        $stmt->bindParam(':tipo_transacao', $_POST['tipo_transacao']);
        $stmt->bindParam(':condominio_id', $_POST['condominio_id']);
        $stmt->bindParam(':morador_id', $_POST['morador_id']);
        $stmt->bindParam(':categoria', $_POST['categoria']);
        $stmt->bindParam(':descricao', $_POST['descricao']);
        $stmt->bindParam(':valor_recebido', $_POST['valor_recebido']);
        $stmt->bindParam(':valor_receber', $_POST['valor_receber']);
        $stmt->bindParam(':data_transacao', $_POST['data_transacao']);
        $stmt->bindParam(':status_pagamento', $_POST['status_pagamento']);
        $stmt->bindParam(':data_vencimento', $_POST['data_vencimento']);
        $stmt->bindParam(':data_pagamento', $_POST['data_pagamento']);

        $stmt->execute();
    }
    echo "Transação adicionada com sucesso!";
} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}
$conn = null;
?>