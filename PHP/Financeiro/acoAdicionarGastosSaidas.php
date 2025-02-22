<?php
$servidor = "154.56.48.204";
$usuario = "u400048496_brunosilva";
$senha = "Bru@1989";
$banco = "u400048496_BdAcoAdm";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $condominio_id = $_POST['condominio_id'];
    $descricao = $_POST['descricao'];
    $valor = $_POST['valor'];
    $data_gasto = $_POST['data_gasto'];
    $tipo_pagamento = $_POST['tipo_pagamento'];
    $status = $_POST['status'];
    $categoria = $_POST['categoria'];
    $observacao = $_POST['observacao'];

    $conn = new PDO("mysql:host=$servidor;dbname=$banco", $usuario, $senha);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->prepare("INSERT INTO saidas (condominio_id, descricao, valor, data_saida, tipo_pagamento, status, categoria) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$condominio_id, $descricao, $valor, $data_gasto, $tipo_pagamento, $status, $categoria]);

    if ($stmt->rowCount()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error']);
    }
}
?>
