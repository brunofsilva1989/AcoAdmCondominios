<?php
if (isset($_GET['file'])) {
    $filePath = $_GET['file'];
    // Verifique se o arquivo existe
    if (file_exists($filePath)) {
        // Forçar o download do arquivo
        header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');
        header('Content-Length: ' . filesize($filePath));
        readfile($filePath);
    } else {
        echo 'Arquivo não encontrado.';
    }
} else {
    echo 'Nenhum arquivo especificado.';
}
?>
