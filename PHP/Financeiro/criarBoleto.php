<?php
// Remove isto quando colocar em produção
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Conexão ao banco de dados
$servidor = "154.56.48.204";
$usuario = "u400048496_brunosilva";
$senha = "Bru@1989";
$banco = "u400048496_BdAcoAdm";


// Configurações de cabeçalho
header('Content-Type: application/json');

try {
    $conn = new PDO("mysql:host=$servidor;dbname=$banco", $usuario, $senha);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($_POST['nome'], $_POST['valor'], $_POST['vencimento'])) {
        $stmt = $conn->prepare("INSERT INTO boletos (nome, valor, vencimento) VALUES (:nome, :valor, :vencimento)");    
        $stmt->bindValue(':nome', $_POST['nome'], PDO::PARAM_STR);
        $stmt->bindValue(':valor', $_POST['valor'], PDO::PARAM_STR); 
        $stmt->bindValue(':vencimento', $_POST['vencimento'], PDO::PARAM_STR);

        if ($stmt->execute()) {
            echo json_encode(["sucesso" => true, "mensagem" => "Boleto criado com sucesso"]);
        } else {
            echo json_encode(["sucesso" => false, "mensagem" => "Erro ao criar boleto"]);
        }
    } else {
        echo json_encode(["sucesso" => false, "mensagem" => "Dados POST não recebidos corretamente"]);
    }
} catch (PDOException $e) {
    // Isso captura erros de conexão e outros erros PDO e exibe uma mensagem de erro.
    // Não exponha `$e->getMessage()` ao usuário final em um ambiente de produção.
    echo json_encode(["sucesso" => false, "mensagem" => "Erro ao conectar ao banco de dados ou ao executar a operação"]);
}
?>