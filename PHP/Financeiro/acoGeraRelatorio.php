
<?php
require('./lib/fpdf186/fpdf.php');

// Informações do banco de dados
$servidor = "154.56.48.204";
$usuario = "u400048496_brunosilva";
$senha = "Bru@1989";
$banco = "u400048496_BdAcoAdm";

try {
    $conexao = new PDO("mysql:host=$servidor;dbname=$banco", $usuario, $senha);
    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Consulta para entradas
    $sqlEntradas = "SELECT * FROM entradas";
    $resultadoEntradas = $conexao->query($sqlEntradas);
    $entradas = $resultadoEntradas->fetchAll(PDO::FETCH_ASSOC);

    // Consulta para saídas
    $sqlSaidas = "SELECT * FROM saidas";
    $resultadoSaidas = $conexao->query($sqlSaidas);
    $saidas = $resultadoSaidas->fetchAll(PDO::FETCH_ASSOC);


    //Gerando relatório em PDF
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(40, 10, 'Olá Mundo!');
    $pdf->Output('D', 'relatorio.pdf');


    // Aqui você pode chamar as funções de cálculo de saldo que foram definidas anteriormente
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $mes = $_POST['mes'];
        $ano = $_POST['ano'];

        $saldoMesAnterior = calcularSaldoMesAnterior($conexao, $mes, $ano);
        $saldoMesAtual = calcularSaldoAtual($conexao, $mes, $ano);
    }

    // Agora, você tem os dados de entradas, saídas e saldos disponíveis para usar no relatório

} catch (PDOException $e) {
    echo "Erro na conexão: " . $e->getMessage();
}
?>