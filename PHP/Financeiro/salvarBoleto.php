<?php
// Você pode usar uma biblioteca como FPDF ou TCPDF para criar um arquivo PDF em PHP
require('fpdf/fpdf.php');

// Conexão ao banco de dados
$servidor = "154.56.48.204";
$usuario = "u400048496_brunosilva";
$senha = "Bru@1989";
$banco = "u400048496_BdAcoAdm";

try {
    $conn = new PDO("mysql:host=$servidor;dbname=$banco", $usuario, $senha);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if(isset($_GET['id'])) {
        $id = $_GET['id'];

        $stmt = $conn->prepare("SELECT * FROM boletos WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $boleto = $stmt->fetch(PDO::FETCH_ASSOC);
        if($boleto) {
            $pdf = new FPDF();
            $pdf->AddPage();
            $pdf->SetFont('Arial','B',16);
            // Aqui você pode formatar a saída como desejar, usando os métodos do FPDF para adicionar texto, imagens, etc.
            $pdf->Cell(40,10, 'Boleto ID: ' . $boleto['id']);
            $pdf->Output('D', 'boleto' . $boleto['id'] . '.pdf');  // 'D' indica que o PDF deve ser baixado pelo usuário
        } else {
            echo "Boleto não encontrado";
        }
    } else {
        echo "ID não fornecido";
    }
} catch (PDOException $e) {
    echo 'Erro ao salvar o boleto';
}

$conn = null;
?>
