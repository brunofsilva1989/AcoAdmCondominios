<?php
$servidor = "154.56.48.204";
$usuario = "u400048496_brunosilva";
$senha = "Bru@1989";
$banco = "u400048496_BdAcoAdm";

try {
    $conn = new PDO("mysql:host=$servidor;dbname=$banco", $usuario, $senha);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $nomeCondominio = $_GET['condominio_id'] ?? ''; // Ajuste o nome do parâmetro conforme necessário

    if (!empty($nomeCondominio)) {
        $stmt = $conn->prepare("
            SELECT clientes.* 
            FROM clientes             
            WHERE clientes.condominio_id = :condominio_id
        ");
        $stmt->bindParam(':condominio_id', $nomeCondominio, PDO::PARAM_INT);
    } else {
        $stmt = $conn->prepare("SELECT * FROM clientes");
    }

    $stmt->execute();
    $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $dadosClientes = [];
    foreach ($resultado as $key => $clientes) {
        $linhaCliente = [
            'id' => htmlspecialchars($clientes['id']),
            'nome' => htmlspecialchars($clientes['nome']),
            'email' => htmlspecialchars($clientes['email']),
            'telefone' => htmlspecialchars($clientes['telefone']),
            'cpf_cnpj' => htmlspecialchars($clientes['cpf_cnpj']),
            'endereco' => htmlspecialchars($clientes['endereco']),
            'numero' => htmlspecialchars($clientes['numero']),
            'complemento' => htmlspecialchars($clientes['complemento']),
            'bairro' => htmlspecialchars($clientes['bairro']),
            'cidade' => htmlspecialchars($clientes['cidade']),
            'estado' => htmlspecialchars($clientes['estado']),
            'cep' => htmlspecialchars($clientes['cep']),
            'condominio_id' => htmlspecialchars($clientes['condominio_id']),
            'acoes' => "<button class='btn btn-outline-primary btn-sm' onclick='window.location.href=\"/acoAlterarCliente.html?id=" 
                       . htmlspecialchars($clientes['id']) . "\"'>Alterar</button> "
                       . "<button class='btn btn-outline-primary btn-sm' onclick='deleteCliente(" . htmlspecialchars($clientes['id']) . ")'>Deletar</button>"
        ];
        $dadosClientes[] = $linhaCliente;
    }

    // Retorna os dados em formato JSON
    echo json_encode(['data' => $dadosClientes]);

} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
    // Em caso de erro, retornar uma estrutura JSON com o erro
    echo json_encode(['error' => 'Erro ao consultar o banco de dados']);
}

$conn = null;
?>