<?php
// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = $_POST["dataManutencao"];
    $responsavel = $_POST["responsavel"];
    $descricao = $_POST["descricao"];
    $custo = $_POST['custo'];
    $custo = preg_replace('/[^\d.]/', '', $custo); // remove qualquer coisa que não seja número ou ponto
    $status = $_POST["statusManutencao"];

    // Conectar ao banco de dados
    $servidor = "154.56.48.204";
    $usuario = "u400048496_brunosilva";
    $senha = "Bru@1989";
    $banco = "u400048496_BdAcoAdm";

    header('Content-Type: application/json');

    try {
        $conn = new PDO("mysql:host=$servidor;dbname=$banco", $usuario, $senha);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Insere os dados no banco de dados
        $stmt = $conn->prepare("INSERT INTO ManutencoesPrediais (dataManutencao, responsavel, descricao, custo, statusManutencao) VALUES (:dataManutencao, :responsavel, :descricao, :custo, :statusManutencao)");
        $stmt->bindParam(':dataManutencao', $data);
        $stmt->bindParam(':responsavel', $responsavel);
        $stmt->bindParam(':descricao', $descricao);
        $stmt->bindParam(':custo', $custo);
        $stmt->bindParam(':statusManutencao', $status);
        $stmt->execute();

        echo json_encode(["success" => true, "message" => "Manutenção cadastrada com sucesso!"]);
    } catch (PDOException $e) {
        // Resposta JSON de erro
        echo json_encode(["success" => false, "message" => "Erro: " . $e->getMessage()]);
    }

    $conn = null;
}
?>