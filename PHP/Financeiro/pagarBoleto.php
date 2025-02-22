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

        // Prepare a consulta SQL
        $stmt = $conn->prepare("UPDATE boletos SET pago = TRUE WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo json_encode(["sucesso" => true, "mensagem" => "Boleto pago com sucesso"]);
        } else {
            echo json_encode(["sucesso" => false, "mensagem" => "Erro ao pagar boleto"]);
        }
    } else {
        echo json_encode(["sucesso" => false, "mensagem" => "ID não fornecido"]);
    }
} catch (PDOException $e) {
    // Captura a exceção e exibe a mensagem de erro
    // Em um ambiente de produção, evite exibir detalhes específicos do erro ao usuário
    echo json_encode(['error' => 'Erro ao processar o pedido']);
}

// Não é necessário chamar close com PDO, apenas definir o objeto como null
$conn = null;
?>
