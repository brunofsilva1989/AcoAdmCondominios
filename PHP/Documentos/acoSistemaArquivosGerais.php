<?php
//Criar um sistema para upload e download de arquivos em php

//Conexão com o banco de dados
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

// Defina o caminho para salvar os arquivos
//$uploadDir = 'arquivos/';
$uploadDir = 'C:\xampp\htdocs\PHP\Documentos\arquivos/';

// Verifique se o arquivo foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['file'])) {
    $file = $_FILES['file'];

    // Verifique se o arquivo é do tipo permitido
    $allowedTypes = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
    if (!in_array($file['type'], $allowedTypes)) {
        die('Tipo de arquivo não permitido.');
    }

    // Crie um nome de arquivo único para evitar sobreposições
    $extensaoOriginal = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $nomeBase = basename($file['name'], '.' . $extensaoOriginal); // Remove a extensão original
    $filename = time() . '_' . $nomeBase;
    $destination = $uploadDir . $filename . '.' . $extensaoOriginal;

    // Tente mover o arquivo para o diretório de upload
    if (move_uploaded_file($file['tmp_name'], $destination)) {
        echo 'Upload realizado com sucesso';
        // Aqui, você deveria salvar as informações do arquivo no banco de dados
        // Conecte-se ao banco de dados
        $conn = new mysqli($servidor, $usuario, $senha, $banco);
        if ($conn->connect_error) {
            die('Falha na conexão: ' . $conn->connect_error);
        }

        // Prepare e execute a consulta SQL
        $sql = "INSERT INTO documentos (nome, tipo, caminho) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sss', $filename, $file['type'], $destination);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo ' e informações salvas no banco de dados.';
        } else {
            echo 'Falha ao salvar informações no banco de dados.';
        }

        // Feche a conexão
        $stmt->close();
        $conn->close();
    } else {
        echo 'Falha no upload do arquivo.' . $_FILES['file']['error'];
    }
} else {
    echo 'Nenhum arquivo enviado.';
}

?>