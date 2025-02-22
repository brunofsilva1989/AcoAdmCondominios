<?php
$servidor = "154.56.48.204";
$usuario = "u400048496_brunosilva";
$senha = "Bru@1989";
$banco = "u400048496_BdAcoAdm";

header('Content-Type: application/json');

try {
    $conn = new PDO("mysql:host=$servidor;dbname=$banco", $usuario, $senha);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Verificar se condominio_id foi passado e não é vazio
    if (isset($_GET['condominio_id']) && !empty($_GET['condominio_id'])) {
        $condominio_id = $_GET['condominio_id'];
        $stmt = $conn->prepare("SELECT id, nome, unidade FROM moradores WHERE condominio_id = :condominio_id");
        $stmt->bindParam(':condominio_id', $condominio_id, PDO::PARAM_INT);
        $stmt->execute();
        $moradores = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        // Se nenhum condominio_id foi passado, retorna todos os moradores
        $moradores = $conn->query("SELECT id, nome, unidade FROM moradores")->fetchAll(PDO::FETCH_ASSOC);
    }

    echo json_encode($moradores);
} catch (PDOException $e) {
    return "Erro: " . $e->getMessage();
}
?>