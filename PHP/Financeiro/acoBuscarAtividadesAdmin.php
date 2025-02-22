<?php
$servidor = "154.56.48.204";
$usuario = "u400048496_brunosilva";
$senha = "Bru@1989";
$banco = "u400048496_BdAcoAdm";

try {
    $conn = new PDO("mysql:host=$servidor;dbname=$banco;charset=utf8", $usuario, $senha);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Prepare a SQL statement to select atividades_admin
    $stmt = $conn->prepare("SELECT atividades_admin FROM transacoes_detalhadas WHERE condominio_id = :condominio_id");
    $condominioId = 1; // Substitua pelo ID do condomínio que você deseja buscar
    $stmt->bindParam(':condominio_id', $condominioId);
    $stmt->execute();

    // Fetch all atividades_admin entries
    $atividades_administrativas = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);

    // Verifique se há atividades administrativas
    if (count($atividades_administrativas) > 0) {
        echo "Atividades administrativas encontradas: ";
        print_r($atividades_administrativas); // Para propósitos de teste
    } else {
        echo "Nenhuma atividade administrativa encontrada para o condomínio especificado.";
    }

} catch(PDOException $e) {
    echo "Erro: " . $e->getMessage();
}
$conn = null;
?>
