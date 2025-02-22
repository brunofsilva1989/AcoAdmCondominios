<?php
$servidor = "154.56.48.204";
$usuario = "u400048496_brunosilva";
$senha = "Bru@1989";
$banco = "u400048496_BdAcoAdm";

header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");

$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
$nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
$endereco = filter_input(INPUT_POST, 'endereco', FILTER_SANITIZE_STRING);
$cep = filter_input(INPUT_POST, 'cep', FILTER_SANITIZE_STRING);
$cidade = filter_input(INPUT_POST, 'cidade', FILTER_SANITIZE_STRING);
$estado = filter_input(INPUT_POST, 'estado', FILTER_SANITIZE_STRING);
$numeroUnidades = filter_input(INPUT_POST, 'numeroUnidades', FILTER_SANITIZE_NUMBER_INT);
$areasComuns = filter_input(INPUT_POST, 'areasComuns', FILTER_SANITIZE_STRING);

// error_log(print_r($_POST, true));

if (!$nome || !$endereco || !$cep || !$cidade || !$estado || !$numeroUnidades || !$areasComuns) {
    echo json_encode(['success' => false, 'message' => 'Preencha todos os campos']);    
    exit;
}

try {
    $conn = new PDO("mysql:host=$servidor;dbname=$banco", $usuario, $senha);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->prepare("UPDATE Condominios SET nome=:nome, endereco=:endereco, cep=:cep, cidade=:cidade, estado=:estado, numeroUnidades=:numeroUnidades, areasComuns=:areasComuns WHERE id=:id");   
    $stmt->bindParam(':id', $id, PDO::PARAM_INT); 
    $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
    $stmt->bindParam(':endereco', $endereco, PDO::PARAM_STR);
    $stmt->bindParam(':cep', $cep, PDO::PARAM_STR);
    $stmt->bindParam(':cidade', $cidade, PDO::PARAM_STR);
    $stmt->bindParam(':estado', $estado, PDO::PARAM_STR);
    $stmt->bindParam(':numeroUnidades', $numeroUnidades, PDO::PARAM_INT);
    $stmt->bindParam(':areasComuns', $areasComuns, PDO::PARAM_STR);
    
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        echo json_encode(['success' => true, 'message' => 'Dados atualizados com sucesso!']);
    } else {
        // Se rowCount() for 0, nenhuma linha foi atualizada. Isso pode acontecer se os dados são os mesmos ou o id não existe.
        echo json_encode(['success' => false, 'message' => 'Nenhuma alteração detectada ou condomínio não encontrado.']);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Erro: ' . $e->getMessage()]);
}

$conn = null;
?>