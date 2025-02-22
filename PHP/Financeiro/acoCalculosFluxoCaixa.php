<?php
// Informações do banco de dados
$servidor = "154.56.48.204";
$usuario = "u400048496_brunosilva";
$senha = "Bru@1989";
$banco = "u400048496_BdAcoAdm";

$conexao = new PDO("mysql:host=$servidor;dbname=$banco", $usuario, $senha);
$conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Calcular saldo do mês anterior
function calcularSaldoMesAnterior($conexao, $mes, $ano) {
    $mesAnterior = $mes - 1;
    if ($mesAnterior == 0) {
        $mesAnterior = 12;
        $ano -= 1;
    }
    $sqlEntradas = "SELECT SUM(valor) as total_entradas FROM entradas WHERE MONTH(data_entrada) = $mesAnterior AND YEAR(data_entrada) = $ano";
    $sqlSaidas = "SELECT SUM(valor) as total_saidas FROM saidas WHERE MONTH(data_saida) = $mesAnterior AND YEAR(data_saida) = $ano";

    // Consulta para entradas
    $resultadoEntradas = $conexao->query($sqlEntradas);
    $entradas = $resultadoEntradas->fetch(PDO::FETCH_ASSOC)['total_entradas'];

    // Consulta para saídas
    $resultadoSaidas = $conexao->query($sqlSaidas);
    $saidas = $resultadoSaidas->fetch(PDO::FETCH_ASSOC)['total_saidas'];

    return $entradas - $saidas;
}

// Calcular saldo do mês atual
function calcularSaldoAtual($conexao, $mes, $ano) {
    $sqlEntradas = "SELECT SUM(valor) as total_entradas FROM entradas WHERE MONTH(data_entrada) <= $mes AND YEAR(data_entrada) = $ano";
    $sqlSaidas = "SELECT SUM(valor) as total_saidas FROM saidas WHERE MONTH(data_saida) <= $mes AND YEAR(data_saida) = $ano";

    // Consulta para entradas
    $resultadoEntradas = $conexao->query($sqlEntradas);
    $entradas = $resultadoEntradas->fetch(PDO::FETCH_ASSOC)['total_entradas'];

    // Consulta para saídas
    $resultadoSaidas = $conexao->query($sqlSaidas);
    $saidas = $resultadoSaidas->fetch(PDO::FETCH_ASSOC)['total_saidas'];

    return $entradas - $saidas;
}
?>
