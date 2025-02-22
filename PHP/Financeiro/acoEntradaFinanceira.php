<?php
$servidor = "154.56.48.204";
$usuario = "u400048496_brunosilva";
$senha = "Bru@1989";
$banco = "u400048496_BdAcoAdm";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $condominio_id = $_POST['condominio_id'];
    $descricao = $_POST['descricao'];
    $valor = $_POST['valor'];
    $data_entrada = $_POST['data_entrada'];

    $conn = new PDO("mysql:host=$servidor;dbname=$banco", $usuario, $senha);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Prepare a query SQL para inserir a entrada financeira
    $stmt = $conn->prepare("INSERT INTO entradas (condominio_id, descricao, valor, data_entrada) VALUES (?, ?, ?, ?)");
    $stmt->execute([$condominio_id, $descricao, $valor, $data_entrada]);

    // Verifique se a entrada foi adicionada com sucesso
    if ($stmt->rowCount()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error']);
    }
}
?>
