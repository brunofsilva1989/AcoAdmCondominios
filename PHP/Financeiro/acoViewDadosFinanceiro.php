<?php
$servidor = "154.56.48.204";
$usuario = "u400048496_brunosilva";
$senha = "Bru@1989";
$banco = "u400048496_BdAcoAdm";

header('Content-Type: application/json');

$condominio_id = isset($_GET['condominio_id']) ? $_GET['condominio_id'] : 0;

// Obter entradas
try {
    $conn = new PDO("mysql:host=$servidor;dbname=$banco", $usuario, $senha);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $entradas = [];
    $stmt = $conn->prepare("SELECT descricao, valor, data_entrada FROM entradas WHERE condominio_id = ?");
    $stmt->execute([$condominio_id]);
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $entradas[] = $row;
    }

    // Obter saídas
    $saidas = [];
    $stmt = $$conn->prepare("SELECT descricao, valor, data_saida FROM saidas WHERE condominio_id = ?");
    $stmt->execute([$condominio_id]);
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $saidas[] = $row;
    }

    // Obter saldo do balancete
    $saldo = [];
    $stmt = $conn->prepare("SELECT mes, ano, saldo_inicial, saldo_final FROM balancetes WHERE condominio_id = ?");
    $stmt->execute([$condominio_id]);
    $saldo = $stmt->fetch(PDO::FETCH_ASSOC);

    echo json_encode([
        'entradas' => $entradas,
        'saidas' => $saidas,
        'saldo' => $saldo
    ]);
} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}
?>