<?php
// Verifique se o usuário está autenticado
session_start();
if (!isset($_SESSION['usuario'])) {
    die("Acesso negado.");
}

// Caminho para o diretório dos documentos
$docPath = '/PHP/Documentos/arquivosCondominio';

// Listar documentos
$docs = array_diff(scandir($docPath), array('..', '.'));

// Retornar a lista de documentos como JSON
header('Content-Type: application/json');
echo json_encode($docs);
?>
