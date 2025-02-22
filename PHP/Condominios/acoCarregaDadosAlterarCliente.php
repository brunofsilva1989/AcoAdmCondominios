<?php

$servidor = "154.56.48.204";
$usuario = "u400048496_brunosilva";
$senha = "Bru@1989";
$banco = "u400048496_BdAcoAdm";

header('Content-Type: application/json');

try {
    $conn = new PDO("mysql:host=$servidor;dbname=$banco", $usuario, $senha);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Coleta dos dados enviados via POST
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $cpf_cnpj = $_POST['cpf_cnpj'];
    $endereco = $_POST['endereco'];
    $numero = $_POST['numero'];
    $complemento = $_POST['complemento'];
    $bairro = $_POST['bairro'];
    $cidade = $_POST['cidade'];
    $estado = $_POST['estado'];
    $cep = $_POST['cep'];

    // Prepare a query de atualização
    $stmt = $conn->prepare("UPDATE clientes SET 
        nome = :nome, 
        email = :email, 
        telefone = :telefone, 
        cpf_cnpj = :cpf_cnpj, 
        endereco = :endereco,
        numero = :numero,
        complemento = :complemento,
        bairro = :bairro,
        cidade = :cidade,
        estado = :estado,
        cep = :cep
        WHERE id = :id");

    // Vinculação de parâmetros
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':telefone', $telefone);
    $stmt->bindParam(':cpf_cnpj', $cpf_cnpj);
    $stmt->bindParam(':endereco', $endereco);
    $stmt->bindParam(':numero', $numero);
    $stmt->bindParam(':complemento', $complemento);
    $stmt->bindParam(':bairro', $bairro);
    $stmt->bindParam(':cidade', $cidade);
    $stmt->bindParam(':estado', $estado);
    $stmt->bindParam(':cep', $cep);

    // Execução da query
    $stmt->execute();

    //Verifica se algum registro foi atualizado
    if ($stmt->rowCount() > 0) {
        echo json_encode(['success' => 'Dados do cliente atualizados com sucesso.']);                
    } else {
        echo json_encode(['warning' => 'Nenhum dado foi alterado.']);        
    }
      

} catch (PDOException $e) {
    echo json_encode(['error' => 'Erro ao atualizar os dados do cliente: ' . $e->getMessage()]);
}

$conn = null;
?>
