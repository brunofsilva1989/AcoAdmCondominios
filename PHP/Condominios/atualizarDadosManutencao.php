<?php
// Conexão com o banco de dados
$servidor = "154.56.48.204";
$usuario = "u400048496_brunosilva";
$senha = "Bru@1989";
$banco = "u400048496_BdAcoAdm";

// Verificar se os dados foram enviados via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $conn = new PDO("mysql:host=$servidor;dbname=$banco", $usuario, $senha);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Pegar os dados do POST
        $id = $_POST['id'];
        $dataManutencao = $_POST['dataManutencao'];
        $responsavel = $_POST['responsavel'];
        $descricao = $_POST['descricao'];
        $custo = $_POST['custo'];
        $statusManutencao = $_POST['status'];

        // Preparar a consulta SQL para atualizar os dados da Manutencao.
        $stmt = $conn->prepare("UPDATE ManutencoesPrediais SET dataManutencao = :dataManutencao, responsavel = :responsavel, descricao = :descricao, custo = :custo, statusManutencao = :statusManutencao WHERE id = :id");      

        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':dataManutencao', $dataManutencao, PDO::PARAM_STR);
        $stmt->bindParam(':responsavel', $responsavel, PDO::PARAM_STR);
        $stmt->bindParam(':descricao', $descricao, PDO::PARAM_STR);
        $stmt->bindParam(':custo', $custo, PDO::PARAM_STR);  
        $stmt->bindParam(':statusManutencao', $statusManutencao, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Dados atualizados com sucesso.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Erro ao atualizar os dados.']);
        }

        
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
}
?>
