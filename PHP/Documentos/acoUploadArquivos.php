<?php
$servidor = "154.56.48.204";
$usuario = "u400048496_brunosilva";
$senha = "Bru@1989";
$banco = "u400048496_BdAcoAdm";
// Defina o caminho para salvar os arquivos
$uploadDir = '../../arquivos/';
//$uploadDir = '../../lib/fpdf186/fpdf.php';
//$uploadDir = 'C:\xampp\htdocs\PHP\Documentos\arquivos/';

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
    $absolutePath = realpath($destination);

    // Tente mover o arquivo para o diretório de upload
    if (move_uploaded_file($file['tmp_name'], $destination)) {
        echo 'Upload realizado com sucesso';
        // Aqui, você deveria salvar as informações do arquivo no banco de dados
        // Conecte-se ao banco de dados
        $conn = new mysqli('154.56.48.204', 'u400048496_brunosilva', 'Bru@1989', 'u400048496_BdAcoAdm');
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

