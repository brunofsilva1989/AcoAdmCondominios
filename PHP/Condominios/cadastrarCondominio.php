<?php

$servidor = "154.56.48.204";
$usuario = "u400048496_brunosilva";
$senha = "Bru@1989";
$banco = "u400048496_BdAcoAdm";

header('Content-Type: application/json');

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar se todos os campos necessários estão definidos
    if (empty($_POST['nome']) || empty($_POST['endereco']) || empty($_POST['cep']) || empty($_POST['cidade']) || empty($_POST['estado']) || empty($_POST['numeroUnidades']) || empty($_POST['areasComuns'])) {
        echo json_encode(['success' => false, 'message' => 'Todos os campos são necessários.']);
        exit; // Interrompe a execução do script
    }

    $nome = $_POST["nome"];
    $endereco = $_POST["endereco"];
    $cep = $_POST["cep"];
    $cidade = $_POST["cidade"];
    $estado = $_POST["estado"];
    $numeroUnidades = $_POST["numeroUnidades"];
    $areasComuns = $_POST["areasComuns"];

    try {
        $conn = new PDO("mysql:host=$servidor;dbname=$banco", $usuario, $senha);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("INSERT INTO Condominios (nome, endereco, cep, cidade, estado, numeroUnidades, areasComuns) VALUES (:nome, :endereco, :cep, :cidade, :estado, :numeroUnidades, :areasComuns)");

        // Bind parameters
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':endereco', $endereco);
        $stmt->bindParam(':cep', $cep);
        $stmt->bindParam(':cidade', $cidade);
        $stmt->bindParam(':estado', $estado);
        $stmt->bindParam(':numeroUnidades', $numeroUnidades, PDO::PARAM_INT);
        $stmt->bindParam(':areasComuns', $areasComuns);

        $stmt->execute();

        echo json_encode(['success' => true, 'message' => "Condomínio cadastrado com sucesso!"]);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => "Erro: " . $e->getMessage()]);
    }
    exit;
}
?>
