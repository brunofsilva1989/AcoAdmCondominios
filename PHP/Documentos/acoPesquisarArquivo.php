<?php
// Substitua com suas informações de conexão ao banco de dados
$servidor = "154.56.48.204";
$usuario = "u400048496_brunosilva";
$senha = "Bru@1989";
$banco = "u400048496_BdAcoAdm";

// Estabeleça uma conexão com o banco de dados
$conn = new mysqli($servidor, $usuario, $senha, $banco);

// Verifique a conexão
if ($conn->connect_error) {
    die('Falha na conexão: ' . $conn->connect_error);
}

// Obtenha o termo de pesquisa do usuário
$searchTerm = $_GET['searchTerm'] ?? '';

// Crie a consulta SQL
$sql = "SELECT id, nome, tipo, caminho FROM documentos WHERE nome LIKE ? OR tipo LIKE ?";

// Prepare e execute a consulta
$stmt = $conn->prepare($sql);
$searchTerm = "%$searchTerm%";
$stmt->bind_param('ss', $searchTerm, $searchTerm);
$stmt->execute();

// Busque os resultados
$result = $stmt->get_result();
$files = $result->fetch_all(MYSQLI_ASSOC);

// Feche a conexão
$stmt->close();
$conn->close();

// Retorne os resultados em formato JSON
echo json_encode($files);
?>
