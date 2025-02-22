<?php

// Inclui a biblioteca PHP QR Code

require_once "phpqrcode/qrlib.php";


// Recebe os dados do formulário
$nome = $_POST["nome"];
$valor = $_POST["valor"];
$QR_ECLEVEL_Q = $_POST["QR_ECLEVEL_Q"];

// Gera o código PIX
$chave_pix = "sua_chave_pix"; // Substitua pela sua chave PIX
$descricao = "Pagamento de $nome";
$payload = "00020126330014BR.GOV.BCB.PIX0114$chave_pix5204000053039865406$descricao5303986540.005802BR5913$nome6009SAO PAULO62070503***6304"; // Monta o payload do PIX
$qrCode = QRcode::png($payload, false, QR_ECLEVEL_Q, 10); // Gera o código QR

// Exibe o código QR na página
echo "<img src='data:image/png;base64," . base64_encode($qrCode) . "'>";

?>