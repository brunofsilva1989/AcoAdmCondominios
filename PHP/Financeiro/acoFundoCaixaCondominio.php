<?php
$servidor = "154.56.48.204";
$usuario = "u400048496_brunosilva";
$senha = "Bru@1989";
$banco = "u400048496_BdAcoAdm";

try {
    $conn = new PDO("mysql:host=$servidor;dbname=$banco", $usuario, $senha);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $condominioId = $_POST['condominio_id9'];
        $caixaMesAnterior = $_POST['caixa_mes_anterior'];
        $mesReferencia = $_POST['mes_referencia']; // Adicione um campo no seu formulário para este valor

        // Ajuste a tabela e os campos conforme a nova estrutura
        $stmt = $conn->prepare("INSERT INTO caixa_condominios (condominio_id, caixa_mes_anterior, mes_referencia) VALUES (:condominio_id, :caixa_mes_anterior, :mes_referencia)");
        $stmt->bindParam(':condominio_id', $condominioId);
        $stmt->bindParam(':caixa_mes_anterior', $caixaMesAnterior);
        $stmt->bindParam(':mes_referencia', $mesReferencia);

        $stmt->execute();

        echo "Caixa do mês anterior registrado com sucesso!";
    }
} catch (PDOException $e) {
    echo "Erro ao conectar ao banco de dados: " . $e->getMessage();
}

$conn = null;
?>
