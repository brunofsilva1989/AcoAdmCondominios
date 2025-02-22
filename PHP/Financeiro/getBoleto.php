<?php
// Conexão ao banco de dados
$servidor = "154.56.48.204";
$usuario = "u400048496_brunosilva";
$senha = "Bru@1989";
$banco = "u400048496_BdAcoAdm";

header('Content-Type: application/json');

try {
    $conn = new PDO("mysql:host=$servidor;dbname=$banco", $usuario, $senha);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if(isset($_POST['id'])) {
        $id = $_POST['id'];

        $stmt = $conn->prepare("SELECT * FROM boletos WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $boleto = $stmt->fetch(PDO::FETCH_ASSOC);
        if($boleto) {
            echo json_encode(["sucesso" => true, "boleto" => $boleto]);
        } else {
            echo json_encode(["sucesso" => false, "mensagem" => "Boleto não encontrado"]);
        }
    } else {
        echo json_encode(["sucesso" => false, "mensagem" => "ID não fornecido"]);
    }
} catch (PDOException $e) {
    echo json_encode(['error' => 'Erro ao recuperar o boleto']);
}

$conn = null;
?>
