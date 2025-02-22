<?php
//Dados do banco de produção
$servidor = "154.56.48.204";
$usuario = "u400048496_brunosilva";
$senha = "Bru@1989";
$banco = "u400048496_BdAcoAdm";

header('Content-Type: application/json');

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Verificar se todos os campos necessários estão definidos
    if (!isset($_POST['nome'], $_POST['unidade'])) {
        echo json_encode(['success' => false, 'message' => 'Todos os campos são necessários.']);
        exit;
    }

    $nome_morador = $_POST['nome'];
    $unidade = $_POST['unidade'];
    $condominio_id = $_POST['condominio_id'];







    $response = ['success' => false, 'message' => ''];

    try {
        $conn = new PDO("mysql:host=$servidor;dbname=$banco", $usuario, $senha);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("INSERT INTO moradores (nome, unidade, condominio_id) VALUES (:nome, :unidade, :condominio_id)");

        // Bind parameters
        $stmt->bindParam(':nome', $nome_morador, PDO::PARAM_STR);
        $stmt->bindParam(':unidade', $unidade, PDO::PARAM_STR);
        $stmt->bindParam(':condominio_id', $condominio_id, PDO::PARAM_INT);

        $stmt->execute();

        echo json_encode(['success' => true, 'message' => "Morador cadastrado com sucesso!"]);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => "Erro: " . $e->getMessage()]);
    }
    exit;
}
