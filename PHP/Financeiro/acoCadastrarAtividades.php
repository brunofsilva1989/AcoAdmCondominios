<?php
// $servidor = "154.56.48.204";
// $usuario = "u400048496_brunosilva";
// $senha = "Bru@1989";
// $banco = "u400048496_BdAcoAdm";

// try {
//     $conn = new PDO("mysql:host=$servidor;dbname=$banco;charset=utf8", $usuario, $senha);
//     $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//     // Busca os condomínios para o formulário
//     $query = "SELECT id, nome FROM condominios";
//     $stmt = $conn->prepare($query);
//     $stmt->execute();
//     $condominios = $stmt->fetchAll(PDO::FETCH_ASSOC);

//     // Verifica se o método é POST e se a atividade foi enviada
//     if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['atividades'])) {
//         // Supondo que você está inserindo uma nova linha na tabela
//         $stmt = $conn->prepare("INSERT INTO transacoes_detalhadas (atividades_admin, condominio_id, data_transacao) VALUES (:atividades_admin, :condominio_id, :data_transacao)");

//         // Bind dos parâmetros (substitua pelos valores corretos)
//         $stmt->bindParam(':atividades_admin', $_POST['atividades']);
//         $condominioId = $_POST['condominio_id4']; // Aqui obtemos o condomínio_id do formulário
//         $stmt->bindParam(':condominio_id', $condominioId);
//         $dataAtual = date('Y-m-d'); // Data atual
//         $stmt->bindParam(':data_transacao', $dataAtual);

//         $stmt->execute();

//         echo "Atividades administrativas adicionadas com sucesso!";
//     }
// } catch (PDOException $e) {
//     echo "Erro: " . $e->getMessage();
// }
// $conn = null;

$servidor = "154.56.48.204";
$usuario = "u400048496_brunosilva";
$senha = "Bru@1989";
$banco = "u400048496_BdAcoAdm";

try {
    $conn = new PDO("mysql:host=$servidor;dbname=$banco;charset=utf8", $usuario, $senha);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['atividades'])) {
        $atividades = $_POST['atividades'];
        $condominioId = $_POST['condominio_id4'] ?? null; // Usa o operador de coalescência nula para lidar com valores nulos
        $dataAtual = date('Y-m-d');

        if (is_null($condominioId)) {
            die("Erro: 'condominio_id' não pode ser nulo.");
        }
        
        $stmt = $conn->prepare("INSERT INTO transacoes_detalhadas (atividades_admin, condominio_id, data_transacao) VALUES (:atividades_admin, :condominio_id, :data_transacao)");
        $stmt->bindParam(':atividades_admin', $_POST['atividades']);
        $stmt->bindParam(':condominio_id', $_POST['condominio_id4']);
        $stmt->bindParam(':data_transacao', $dataAtual);
        $stmt->execute();

        echo "Atividades administrativas adicionadas com sucesso!";
    } else {
        echo "Dados insuficientes para cadastrar atividades.";
    }
} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();

    // Aqui você pode adicionar o código HTML para mostrar o formulário
// (!empty($_POST['atividades']) && !empty($_POST['condominio_id4'])) {
//     $atividades = $_POST['atividades'];
//     $condominioId = $_POST['condominio_id4'];

}
$conn = null;
?>
