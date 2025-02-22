<?php
$condominio = 'condominio1'; // Aqui, substitua pelo código que recupera o condomínio do usuário logado
$dir = "uploads/$condominio/";

$files = scandir($dir);

foreach ($files as $file) {
    if ($file != '.' && $file != '..') {
        echo "<a href='$dir$file' download>$file</a><br>";
    }
}
?>
