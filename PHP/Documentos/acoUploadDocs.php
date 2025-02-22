<?php
if(isset($_POST["submit"])) {
    $condominio = $_POST['condominio'];
    $target_dir = "uploads/$condominio/";
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $target_file = $target_dir . basename($_FILES["file"]["name"]);
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    // Verificar o tamanho do arquivo
    if ($_FILES["file"]["size"] > 1000000000) { // 1GB
        echo "O arquivo é muito grande.";
        $uploadOk = 0;
    }

    // Permitir certos formatos de arquivo
    if($fileType != "pdf" && $fileType != "doc" && $fileType != "docx"
    && $fileType != "xls" && $fileType != "xlsx" && $fileType != "csv" ) {
        echo "Somente arquivos PDF, DOC, DOCX, XLS, XLSX, CSV são permitidos.";
        $uploadOk = 0;
    }

    // Verificar se $uploadOk está definido como 0 por um erro
    if ($uploadOk == 0) {
        echo "Desculpe, seu arquivo não foi enviado.";
    } else {
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
            echo "O arquivo ". htmlspecialchars( basename( $_FILES["file"]["name"])). " foi enviado.";
            // Aqui, adicione o código para salvar a informação do arquivo no banco de dados
        } else {
            echo "Houve um erro ao enviar o arquivo.";
        }
    }
}
?>
