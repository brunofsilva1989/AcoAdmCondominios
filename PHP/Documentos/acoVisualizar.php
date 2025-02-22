<?php
if (isset($_GET['file'])) {
    $filePath = $_GET['file'];
    $absolutePath = realpath($filePath);
    if ($absolutePath && file_exists($absolutePath) && mime_content_type($absolutePath) == 'application/pdf') {        
        header('Content-Type: ' . mime_content_type($filePath));
        // Enviar o arquivo para o navegador
        readfile($filePath);
        exit;
    } else {
        echo 'Arquivo não encontrado ou tipo de arquivo não suportado.';
    }
} else {
    echo 'Nenhum arquivo especificado.';
}
?>
