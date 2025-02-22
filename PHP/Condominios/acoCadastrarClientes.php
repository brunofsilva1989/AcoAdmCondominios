<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (!isset($_POST['nome'], $_POST['email'], $_POST['telefone'], $_POST['cpf_cnpj'], $_POST['endereco'], $_POST['numero'], $_POST['bairro'], $_POST['cidade'], $_POST['estado'], $_POST['cep'])) {
        echo json_encode(['success' => false, 'message' => 'Todos os campos são necessários.']);
        exit;
    }

    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $cpf_cnpj = $_POST['cpf_cnpj'];
    $endereco = $_POST['endereco'];
    $numero = $_POST['numero'];
    $complemento = $_POST['complemento'] ?? null;  // O campo complemento é opcional
    $bairro = $_POST['bairro'];
    $cidade = $_POST['cidade'];
    $estado = $_POST['estado'];
    $cep = $_POST['cep'];
    $condominio_id = $_POST['condominio_id'];

    header('Content-Type: application/json');

    $servidor = "154.56.48.204";
    $usuario = "u400048496_brunosilva";
    $senha = "Bru@1989";
    $banco = "u400048496_BdAcoAdm";

    $response = ['success' => false, 'message' => ''];

    try {
        $conn = new PDO("mysql:host=$servidor;dbname=$banco", $usuario, $senha);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("INSERT INTO clientes (nome, email, telefone, cpf_cnpj, endereco, numero, complemento, bairro, cidade, estado, cep, condominio_id) VALUES (:nome, :email, :telefone, :cpf_cnpj, :endereco, :numero, :complemento, :bairro, :cidade, :estado, :cep, :condominio_id)");

        

        $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':telefone', $telefone, PDO::PARAM_STR);
        $stmt->bindParam(':cpf_cnpj', $cpf_cnpj, PDO::PARAM_STR);
        $stmt->bindParam(':endereco', $endereco, PDO::PARAM_STR);
        $stmt->bindParam(':numero', $numero, PDO::PARAM_STR);
        $stmt->bindParam(':complemento', $complemento, PDO::PARAM_STR); // O campo complemento é opcional
        $stmt->bindParam(':bairro', $bairro, PDO::PARAM_STR);
        $stmt->bindParam(':cidade', $cidade, PDO::PARAM_STR);
        $stmt->bindParam(':estado', $estado, PDO::PARAM_STR);
        $stmt->bindParam(':cep', $cep, PDO::PARAM_STR);
        $stmt->bindParam(':condominio_id', $condominio_id, PDO::PARAM_INT);

        $stmt->execute();

        //file_put_contents("log.txt", json_encode($_POST) . "\n", FILE_APPEND); // Logar o POST recebido

        
        echo json_encode(['success' => true, 'message' => "Cliente cadastrado com sucesso!"]);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => "Erro: " . $e->getMessage()]);
    }
    exit;
}
?>
