<?php
require('../../lib/fpdf186/fpdf.php');
// Informações do banco de dados
$servidor = "154.56.48.204";
$usuario = "u400048496_brunosilva";
$senha = "Bru@1989";
$banco = "u400048496_BdAcoAdm";

ob_start(); // Inicia o buffer de saída

try {
    $conexao = new PDO("mysql:host=$servidor;dbname=$banco;charset=utf8", $usuario, $senha);
    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Funções para cálculos
    // *** CONSULTAS DE BANCO E CALCULOS PARA VERIFICAR VALORES *** // 
    function calcularTotalTransacoes($conexao, $condominioId, $tipoTransacao, $tipoValor, $dataInicio, $dataFim)
    {
        // Escolher a coluna correta com base no tipo de valor (recebido ou a receber)
        $colunaValor = $tipoValor === 'recebido' ? 'valor_recebido' : 'valor_receber';

        $stmt = $conexao->prepare("
        SELECT SUM($colunaValor) AS total 
        FROM transacoes_detalhadas 
        WHERE condominio_id = :condominioId 
        AND tipo_transacao = :tipoTransacao 
        AND data_transacao BETWEEN :dataInicio AND :dataFim
    ");
        $stmt->bindParam(':condominioId', $condominioId);
        $stmt->bindParam(':tipoTransacao', $tipoTransacao);
        $stmt->bindParam(':dataInicio', $dataInicio);
        $stmt->bindParam(':dataFim', $dataFim);
        $stmt->execute();
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        return $resultado['total'] ?? 0; // Retorna 0 se não houver transações
    }

    //Preciso criar uma consulta uma função qeu traga as informações da tabela saidas, para que eu possa somar e trazer o total de saidas.

    // Variáveis para cálculos
    $mes = date('m'); // Mês atual
    $ano = date('Y'); // Ano atual

    // Substitua pelos dados recebidos via GET após validação e sanitização
    $condominioId = $_GET['condominio_id3'];
    $dataInicio = $_GET['data_inicio'];
    $dataFim = $_GET['data_fim'];

    // Obter o nome do condomínio
    $stmt = $conexao->prepare("SELECT nome FROM Condominios WHERE id = :condominioId");
    $stmt->bindParam(':condominioId', $condominioId);
    $stmt->execute();
    $nomeCondominio = $stmt->fetchColumn();

    if ($nomeCondominio === false) {
        echo "Condomínio não encontrado.";
        exit; // Encerra a execução do script
    }


    // Consulta para transações detalhadas com nome do morador e unidade
    $stmt = $conexao->prepare("
     SELECT td.*, m.nome AS nome_morador, m.unidade
     FROM transacoes_detalhadas td
     JOIN moradores m ON td.morador_id = m.id
     WHERE td.condominio_id = :condominioId AND td.data_transacao BETWEEN :dataInicio AND :dataFim
    ");
    $stmt->bindParam(':condominioId', $condominioId);
    $stmt->bindParam(':dataInicio', $dataInicio);
    $stmt->bindParam(':dataFim', $dataFim);
    $stmt->execute();
    $transacoes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Consulta para obter os dados do condomínio
    $stmt = $conexao->prepare("SELECT nome, endereco, cidade, estado, cep FROM Condominios WHERE id = :condominioId");
    $stmt->bindParam(':condominioId', $condominioId);
    $stmt->execute();
    $condominio = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verificar se o condomínio foi encontrado
    if (!$condominio) {
        echo "Condomínio não encontrado.";
        exit; // Encerra a execução do script
    }


    // Obtém os dados das atividades administrativas
    $query = "SELECT atividades_admin FROM transacoes_detalhadas WHERE condominio_id = :condominio_id";
    $stmt = $conexao->prepare($query);
    $stmt->bindParam(':condominio_id', $condominioId);
    $stmt->execute();
    $atividades_administrativas = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);

    // Obtémn o total em caixa do mes anterior
    $query = "SELECT caixa_mes_anterior FROM caixa_condominios WHERE condominio_id = :condominio_id ORDER BY mes_referencia DESC LIMIT 1";
    $stmt = $conexao->prepare($query);
    $stmt->bindParam(':condominio_id', $condominioId);
    $stmt->execute();
    $caixa_mes_anterior = $stmt->fetchColumn();

    //Verifica se existe o valor do mes anterior senão mantem zero no caixa
    if (!$caixa_mes_anterior) {
        $caixa_mes_anterior = 0;
    }

    // Definir o local para português do Brasil
    setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');

    $stmt = $conexao->prepare("
    SELECT s.descricao, s.valor, s.observacao 
    FROM saidas s
    WHERE s.condominio_id = :condominioId AND s.data_saida BETWEEN :dataInicio AND :dataFim
    ORDER BY s.data_saida ASC
    ");
    $stmt->bindParam(':condominioId', $condominioId);
    $stmt->bindParam(':dataInicio', $dataInicio);
    $stmt->bindParam(':dataFim', $dataFim);
    $stmt->execute();
    $saidas = $stmt->fetchAll(PDO::FETCH_ASSOC);


    // *** FIM DAS CONSULTAS DE BANCO E CALCULOS PARA VERIFICAR VALORES *** //


    // *** CÁLCULOS *** //

    // Calcula o total de entradas
    $totalRecebido = calcularTotalTransacoes($conexao, $condominioId, $tipoTransacao, 'recebido', $dataInicio, $dataFim);
    $totalAReceber = calcularTotalTransacoes($conexao, $condominioId, $tipoTransacao, 'a_receber', $dataInicio, $dataFim);


    //A RECEBER - Sempre será o valor total de entradas
    $aReceber = $totalAReceber;

    //RECEBIDO - Sempre será o valor total que os condominos pagaram
    $recebidoCondiminio = $totalRecebido;

    // DIFERENCA - Sempre será o valor total de entradas menos o valor total que os condominos pagaram
    $diferenca = $aReceber - $recebidoCondiminio;

    // CAIXA DO MÊS ANTERIOR - Precisa ser um acumulado do mes passado, de forma automatica
    $saldoMesAnterior = $caixa_mes_anterior;

    // Calcula o Saldo final
    $saldoFinal = $saldoMesAnterior + $totalRecebido - $totalSaidasTransacoes;

    // Gera a referência com base no mês e ano atual
    $referencia = strftime('%b/%y'); // Referência como mês abreviado/ano atual


    //*** MONTAGEM DO RELATÓRIO EM PDF ***//
    $pdf = new FPDF();
    $pdf->AddPage();

    //$logoPath = 'C:/xampp/htdocs/img/logo.png'; // Substitua pelo caminho real do arquivo de imagem do logotipo.
    $logoPath = '../../img/logo.png';
    $pdf->Image($logoPath, 10, 10, 40); // Insere o logotipo
    $pdf->Ln();

    // Configurar a fonte para o título
    $pdf->SetFont('Times', 'B', 14);

    // Mexe no título do balancete
    $pdf->SetY(5); // Ajuste o valor se necessário para alinhar verticalmente com o logotipo
    $pdf->SetX(50); // Ajuste o valor para posicionar o título ao lado do logotipo
    $pdf->Cell(0, 10, utf8_decode('             Balancete Financeiro - ' . $nomeCondominio), 0, 1, 'L'); // Título alinhado à esquerda
    $pdf->Ln(50);

    // Mexe no campo da referência
    $pdf->SetFont('Times', '', 12);
    $pdf->SetY(30); // Ajuste a posição Y conforme necessário
    $pdf->SetX(-60); // Ajuste a posição X conforme necessário (negativo para alinhamento à direita)
    $pdf->Cell(50, 10, 'Referencia: ' . $referencia, 1, 0, 'C'); // Caixa com borda
    $pdf->Ln(10);

    // Adicionar informações do controle administrativo com endereço do condomínio
    $enderecoCompleto = utf8_decode("Controle Administrativo\nTaxa de Limpeza, Contas de consumo.\n\n" . $condominio['endereco'] . "- " . $condominio['cidade'] . " - " . $condominio['estado'] . " - CEP " . $condominio['cep']);
    $pdf->SetFont('Times', '', 11);
    $pdf->SetY(40); // Ajuste a posição Y conforme necessário
    $pdf->SetX(10); // Ajuste a posição X conforme necessário
    $pdf->MultiCell(0, 5, $enderecoCompleto, 0, 'L', false);
    $pdf->Ln(10); // Espaço depois do cabeçalho

    // LARGURAS PARA A TABELA DE DADOS DAS TRANSAÇÕES
    $larguraUnidade = 18;
    $larguraMorador = 50;
    $larguraData = 30;
    $larguraDescricao = 30;
    $larguraValor = 30;
    $larguraValor2 = 30;
    $larguraTotal = 25;

    // *** CABEÇALHO DA TABELA PROJEÇÃO - ENTRADA*** //
    $pdf->SetFont('Times', 'B', 12);
    $pdf->Cell(0, 10, utf8_decode('PROJEÇÃO - ENTRADA'), 0, 1);
    $pdf->SetFont('Times', 'B', 10); // Fonte um pouco maior para o cabeçalho
    $pdf->Cell($larguraUnidade, 7, 'Unidade', 1);
    $pdf->Cell($larguraMorador, 7, 'Moradores', 1);
    $pdf->Cell($larguraData, 7, 'Data', 1);
    $pdf->Cell($larguraDescricao, 7, utf8_decode('Posicão'), 1);
    $pdf->Cell($larguraValor2, 7, 'Valor Receber', 1);
    $pdf->Cell($larguraValor, 7, 'Valor Recebido', 1);
    $pdf->Ln();

    // Variável para guardar o total de valor recebido
    $totalValorRecebido = 0;

    // Se não houver dados, exiba uma mensagem e encerre a execução do script
    if (count($transacoes) == 0) {
        $pdf->Cell(0, 10, utf8_decode('Nenhuma transação encontrada.'), 0, 1, 'C');
       // $pdf->Output('I', 'relatorio.pdf'); // Abre no navegador
        exit;
    }

    // *** DADOS DA TABELA PROJEÇÃO - ENTRADA*** //    
    $pdf->SetFont('Times', '', 10);
    foreach ($transacoes as $transacao) {
        $pdf->Cell($larguraUnidade, 6, utf8_decode($transacao['unidade']), 1);
        $pdf->Cell($larguraMorador, 6, utf8_decode($transacao['nome_morador']), 1);
        $pdf->Cell($larguraData, 6, date('d/m/Y', strtotime($transacao['data_transacao'])), 1);
        $pdf->Cell($larguraDescricao, 6, utf8_decode($transacao['descricao']), 1);
        $valorFormatado2 = number_format($transacao['valor_receber'], 2, ',', '.');
        $pdf->Cell($larguraValor2, 6, "R$" . $valorFormatado, 1, 0, 'R'); // Alinhamento à direita
        $valorFormatado = number_format($transacao['valor_recebido'], 2, ',', '.');
        $pdf->Cell($larguraValor, 6, "R$" . $valorFormatado, 1, 0, 'R'); // Alinhamento à direita
        $pdf->Ln();

        // Adicionar ao total
        $totalValorRecebido += $transacao['valor_recebido'];
        $aReceber += $transacao['valor_receber'];
    }

    // *** VALOR TOTAL QUE APARECE NO FIM DA TABELA *** //    
    $larguraTotal = $larguraUnidade + $larguraMorador + $larguraData + $larguraDescricao;
    $larguraValorTotal = $larguraValor;

    $pdf->SetFont('Times', 'B', 11); // 
    $pdf->Cell($larguraTotal, 7, 'Total Recebido', 1);
    $pdf->Cell($larguraValorTotal, 7, "R$" . number_format($totalValorRecebido, 2, ',', '.'), 1, 0, 'R'); // Alinhamento à direita
    $pdf->Ln(20);

    //*** ATIVIDADES ADMINISTRATIVAS EXECUTADAS ***//
    $pdf->SetFont('Times', 'B', 14);
    $pdf->Cell(0, 10, utf8_decode(''), 0, 2, 'L'); // Título centralizado    
    $y = $pdf->GetY();
    $pdf->SetY($y - 10);

    // Largura e altura para as células da tabela
    $larguraAtividade = 158; // Ajuste conforme a largura desejada para a coluna
    $alturaLinha = 5; // Ajuste conforme a altura desejada para cada linha

    // Cabeçalho da tabela
    $pdf->SetFont('Times', 'B', 14);
    $pdf->Cell($larguraAtividade, $alturaLinha, 'Atividades Administrativas Executadas', 'LTR', 15, 'L'); // Cabeçalho com borda superior, lateral esquerda e direita
    $y = $pdf->GetY();
    $pdf->SetY($y - 25);

    //TRAZ OS DADOS INPUTADOS NO ATIVIDADES ADMINISTRATIVAS DA TELA.
    $pdf->SetFont('Times', '', 12);
    foreach ($atividades_administrativas as $atividade) {
        $pdf->MultiCell($larguraAtividade, $alturaLinha, utf8_decode($atividade), 'LR', 'L');
    }
    $pdf->Cell($larguraAtividade, 0, '', 'LRB', 1);

    //Footer e Data da geração da Primeira Página. 
    $pdf->SetY(-40);
    $pdf->SetFont('Times', 'I', 10);
    $pdf->Cell(0, 10, 'Gerado em: ' . date('d/m/Y'), 0, 0, 'C');
    $pdf->Ln();
    // *_* FIM DA PRIMEIRA PÁGINA DO RELATÓRIO *_* //



    // *_* SEGUNDA PÁGINA DO RELATÓRIO *_* //
    $pdf->AddPage();
    $logoPath = '../../img/logo.png';
    $pdf->Image($logoPath, 10, 10, 40); // Insere o logotipo
    $pdf->Ln();

    //Titiulo do Balancete
    $pdf->SetFont('Times', 'B', 14);
    $pdf->SetY(5); // Ajuste o valor se necessário para alinhar verticalmente com o logotipo
    $pdf->SetX(50); // Ajuste o valor para posicionar o título ao lado do logotipo
    $pdf->Cell(0, 10, utf8_decode('             Balancete Financeiro - ' . $nomeCondominio), 0, 1, 'L'); // Título alinhado à esquerda
    $pdf->Ln();
    $pdf->Ln();
    $pdf->Ln();

    //CAMPO A RECEBER - Preciso ver como vir esse valor inputado pela pessoa cadastradora    
    //$pdf->AddPage();
    $pdf->SetFont('Times', 'B', 14);
    $pdf->Cell(0, 10, utf8_decode('FLUXO DE CAIXA : ' . $nomeCondominio), 0, 1, 'C');


    //*** ENTRADAS: OK ***

    // Cálculos //

    // Removendo o formato monetário
    $aReceber = floatval(str_replace([",", "R$ "], [".", ""], $aReceber));
    $totalValorRecebido = floatval(str_replace([",", "R$ "], [".", ""], $totalValorRecebido));
    // Calculando a diferença
    $diferenca = $totalValorRecebido - $aReceber;

    $totalCaixa = $totalValorRecebido + $saldoMesAnterior;

    $pdf->SetFont('Times', 'B', 12);
    $pdf->Cell(0, 10, utf8_decode('ENTRADAS: '), 0, 1); // OK
    $pdf->SetFont('Times', '', 12);
    $pdf->Cell(50, 10, utf8_decode('A Receber: ')); // OK
    $pdf->Cell(50, 10, 'R$' . number_format($aReceber, 2, ',', '.'), 0, 0, 'R');
    $pdf->Ln();
    $pdf->Cell(50, 10, utf8_decode('Recebido: ')); // OK
    $pdf->Cell(50, 10, 'R$' . number_format($totalValorRecebido, 2, ',', '.'), 0, 0, 'R'); // Assumindo que o total de entradas é o total recebido - TESTEI OK
    $pdf->Ln();
    $pdf->Cell(50, 10, utf8_decode('Diferença: ')); // OK
    $pdf->Cell(50, 10, 'R$' . number_format($diferenca, 2, ',', '.'), 0, 0, 'R'); // Diferença é zero se você não tem essa informação - TESTEI OK
    $pdf->Ln();
    $pdf->Cell(50, 10, utf8_decode('Caixa do mês anterior: ')); // É UM CAMPO CRIADO NA TABELA PARA IMPUTAR ESSE VALOR MANUALMENTE PELA CADASTRADORA
    $pdf->Cell(50, 10, 'R$' . number_format($saldoMesAnterior, 2, ',', '.'), 0, 0, 'R');
    $pdf->Ln();
    $pdf->SetFont('Times', 'B', 12);
    $pdf->Cell(50, 10, utf8_decode('TOTAL DO CAIXA: ')); // É A SOMA DE TODAS AS ENTRADAS E O CAIXA SE HOUVER - TESTEI OK
    $pdf->Cell(50, 10, 'R$' . number_format($totalCaixa, 2, ',', '.'), 0, 0, 'R');
    $pdf->Ln();
    $pdf->Ln();

    // SAÍDAS:
    // Definindo as larguras das colunas
    $larguraDescricao = 80;
    $larguraValor = 20;
    $larguraObservacao = 90;

    $pdf->SetFont('Times', 'B', 12);
    $pdf->Cell(0, 10, utf8_decode('SAÍDAS'), 0, 1);

    // Cabeçalho das colunas
    $pdf->SetFont('Times', 'B', 12);
    $pdf->Cell($larguraDescricao, 10, 'Descricao', 1, 0, 'C');
    $pdf->Cell($larguraValor, 10, 'Valor', 1, 0, 'C');
    $pdf->Cell($larguraObservacao, 10, 'Observacao', 1, 1, 'C'); // O último parâmetro '1' significa que o cursor vai para a próxima linha após esta célula

    // Restaurando a fonte para os dados
    $pdf->SetFont('Times', '', 12);

    // Variável para somar o total
    $valorTotal = 0;

    foreach ($saidas as $saida) {
        $descricao = $saida['descricao'];
        $valor = number_format($saida['valor'], 2, ',', '.');
        $observacao = $saida['observacao'];

        // Somando ao total
        $valorTotal += $saida['valor'];

        // Exibindo os dados
        $pdf->Cell($larguraDescricao, 10, utf8_decode($descricao), 1);
        $pdf->Cell($larguraValor, 10, $valor, 1, 0, 'R'); // Alinhamento à direita para valores monetários
        $pdf->Cell($larguraObservacao, 10, utf8_decode($observacao), 1, 1); // Passar para a próxima linha após a última célula
    }

    // Exibindo o total das saídas
    $pdf->SetFont('Times', 'B', 12);
    $pdf->Cell($larguraDescricao + $larguraValor, 10, 'Total Gastos                                                 ' . 'R$ ' . number_format($valorTotal, 2, ',', '.'), 1, 0, 'L');
    //$pdf->Cell($larguraObservacao, 10, 'R$ ' . number_format($valorTotal, 2, ',', '.'), 1, 1, 'L');

    $pdf->Ln();
    $pdf->Ln();

    // Saldo Final
    $caixaFinal = $totalCaixa - $valorTotal;

    // Total Gastos Saidas e Saldo Final    
    $pdf->Cell(50, 10, 'CAIXA:');
    $pdf->Cell(50, 10, 'R$' . number_format($caixaFinal, 2, ',', '.'), 0, 0, 'R');
    $pdf->Ln();


    // Espaço antes do rodapé
    $pdf->SetY(-40);
    $pdf->SetFont('Times', 'I', 10);
    $pdf->Cell(0, 10, 'Gerado em: ' . date('d/m/Y'), 0, 0, 'C');
    ob_end_clean(); // Limpa o buffer e desativa o buffer de saída
    $pdf->Output('I', 'relatorio.pdf'); // Abre no navegador
    // Encerra a execução do script
} catch (PDOException $e) {
    ob_end_clean();
    echo "Erro na conexão: " . $e->getMessage();
}
