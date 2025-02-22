// //Visualizar dados financeiros do condominio
// $(document).ready(function () {
//     const condominioId = 1; // Substitua pelo ID do condomínio desejado

//     function atualizarBalancete() {
//         $.ajax({
//             url: '/PHP/Financeiro/acoViewDadosFinanceiro.php',
//             type: 'GET',
//             data: { condominio_id: condominioId },
//             dataType: 'json',
//             success: function (response) {
//                 const { entradas, saidas, saldo } = response;

//                 // Limpa o conteúdo anterior
//                 $('#balancete').empty();

//                 // Cria e insere a tabela de entradas
//                 let tabelaEntradas = $('<table/>').addClass('table');
//                 tabelaEntradas.append('<tr><th>Descrição</th><th>Valor</th><th>Data</th></tr>');
//                 $.each(entradas, function (i, entrada) {
//                     tabelaEntradas.append(`<tr><td>${entrada.descricao}</td><td>R$ ${entrada.valor.toFixed(2)}</td><td>${entrada.data_entrada}</td></tr>`);
//                 });
//                 $('#balancete').append('<h3>Entradas</h3>').append(tabelaEntradas);

//                 // Cria e insere a tabela de saídas
//                 let tabelaSaidas = $('<table/>').addClass('table');
//                 tabelaSaidas.append('<tr><th>Descrição</th><th>Valor</th><th>Data</th></tr>');
//                 $.each(saidas, function (i, saida) {
//                     tabelaSaidas.append(`<tr><td>${saida.descricao}</td><td>R$ ${saida.valor.toFixed(2)}</td><td>${saida.data_saida}</td></tr>`);
//                 });
//                 $('#balancete').append('<h3>Saídas</h3>').append(tabelaSaidas);

//                 // Exibe o saldo
//                 let saldoDiv = $('<div/>');
//                 saldoDiv.append(`<p><strong>Saldo Inicial:</strong> R$ ${saldo.saldo_inicial.toFixed(2)}</p>`);
//                 saldoDiv.append(`<p><strong>Saldo Final:</strong> R$ ${saldo.saldo_final.toFixed(2)}</p>`);
//                 $('#balancete').append('<h3>Saldo</h3>').append(saldoDiv);
//             },
//             error: function (xhr, status, error) {
//                 console.error("Erro ao obter dados: ", error);
//             }
//         });
//     }

//     atualizarBalancete();
// });


//Retorna lista de condominios para cadastro de Saídas Financeiras
$(document).ready(function () {
    // Carregar a lista de condomínios
    function loadCondominios() {
        $.ajax({
            url: '/PHP/Financeiro/acoBuscaCondominioFin.php', // Este script PHP deve retornar uma lista de condomínios
            type: 'GET',
            dataType: 'json',
            success: function (condominios) {
                $.each(condominios, function (key, condominio) {
                    $('#condominio_id2').append(new Option(condominio.nome, condominio.id));
                });
            }
        });
    }

    // Carrega os moradores quando um condomínio é selecionado
    $('#condominio_id2').change(function () {
        var condominioId = $(this).val(); // Pega o ID do condomínio selecionado
        loadMoradores(condominioId); // Carrega os moradores para este condomínio
    });

    //Carrega Moradores cadastrados para cadastro de saídas
    function loadMoradores(condominioId) {
        $.ajax({
            url: '/PHP/Financeiro/acoBuscarMorador.php', // Este script PHP deve retornar uma lista de condomínios
            type: 'GET',
            data: { condominio_id: condominioId },
            dataType: 'json',
            success: function (moradores) {
                const select = $('#morador_id2');
                select.empty();
                $.each(moradores, function (index, moradores) {
                    select.append(new Option(moradores.nome, moradores.id));
                });
            }
        });
    }

    // Enviar o formulário e adicionar o gasto
    $('#addExpenseForm').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            url: '/PHP/Financeiro/acoAdicionarGastosSaidas.php', // Este script PHP irá processar o cadastro do gasto
            type: 'POST',
            data: $(this).serialize(),
            success: function (response) {
                showMessage('Gasto adicionado com sucesso!');
                // Limpar o formulário ou redirecionar o usuário
                setTimeout(function () {
                    window.location.href = "/acoCadastroFinanceiro.html";
                }, 2500);
            },

            error: function () {
                showMessage('Erro ao adicionar gasto.');
            }
        });
    });

    loadCondominios(); // Chama a função ao carregar a página
    loadMoradores();
});


//** */ 1° FUNCAO FINANCEIRA - De acordo como está no html **//

//*** 1° Cadastro de Transações Financeiras ***//
$(document).ready(function () {
    // Carregar a lista de condomínios
    function loadCondominios() {
        $.ajax({
            url: '/PHP/Financeiro/acoBuscaCondominioFin.php', // Este script PHP deve retornar uma lista de condomínios
            type: 'GET',
            dataType: 'json',
            success: function (condominios) {
                $.each(condominios, function (key, condominio) {
                    $('#condominio_id3').append(new Option(condominio.nome, condominio.id));
                });
            }
        });
    }

    // Carrega os moradores quando um condomínio é selecionado
    $('#condominio_id3').change(function () {
        var condominioId = $(this).val(); // Pega o ID do condomínio selecionado
        loadMoradores(condominioId); // Carrega os moradores para este condomínio
    });

    //Carrega Moradores cadastrados para cadastro de saídas
    function loadMoradores(condominioId) {
        $.ajax({
            url: '/PHP/Financeiro/acoBuscarMorador.php', // Este script PHP deve retornar uma lista de condomínios
            type: 'GET',
            data: { condominio_id: condominioId },
            dataType: 'json',
            success: function (moradores) {
                const select = $('#morador_id3');
                select.empty();
                $.each(moradores, function (index, moradores) {
                    select.append(new Option(moradores.nome, moradores.id));
                });
            }
        });
    }


    $(document).ready(function () {
        $('#formFinanceiro').on('submit', function (e) {
            e.preventDefault();
            

            $.ajax({
                url: '/PHP/Financeiro/acoCadastroFinanceiro.php', 
                type: 'POST',
                data: $(this).serialize(),
                success: function (response) {                                        
                    console.log(response);
                    Swal.fire({
                        icon: 'success',
                        title: 'Sucesso!',
                        text: 'Transação adicionada com sucesso!'
                        
                    });
                    setTimeout(function () {
                        window.location.href = "/acoCadastroFinanceiro.html";
                    }, 2500);
                },
                error: function (xhr, status, error) {
                    // Trate erros aqui. Exemplo:
                    alert("Erro ao adicionar transação.");
                }
            });
        });
    });

    loadCondominios(); // Chama a função ao carregar a página
    loadMoradores();

});

//CAIXA MÊS ANTERIOR - Transações Financeiras.
$(document).ready(function () {
    // Carregar a lista de condomínios
    function loadCondominios() {
        $.ajax({
            url: '/PHP/Financeiro/acoBuscaCondominioFin.php', // Este script PHP deve retornar uma lista de condomínios
            type: 'GET',
            dataType: 'json',
            success: function (condominios) {
                $.each(condominios, function (key, condominio) {
                    $('#condominio_id9').append(new Option(condominio.nome, condominio.id));
                });
            }
        });
    }

    // Carrega os moradores quando um condomínio é selecionado
    $('#condominio_id9').change(function () {
        var condominioId = $(this).val(); // Pega o ID do condomínio selecionado
        loadMoradores(condominioId); // Carrega os moradores para este condomínio
    });


    $(document).ready(function () {
        $('#formFundoCaixa').on('submit', function (e) {
            e.preventDefault();

            $.ajax({
                url: '/PHP/Financeiro/acoFundoCaixaCondominio.php', // Substitua pelo caminho correto
                type: 'POST',
                data: $(this).serialize(),
                success: function (response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Sucesso!',
                        text: 'Transação adicionada com sucesso!'
                    });
                    setTimeout(function () {
                        window.location.href = "/acoCadastroFinanceiro.html";
                    }, 2500);
                },
                error: function (xhr, status, error) {
                    // Trate erros aqui. Exemplo:
                    alert("Erro ao adicionar transação.");
                }
            });
        });
    });

    loadCondominios(); // Chama a função ao carregar a página    

});

//MOSTRA TABELA DE TRANSAÇÕES FINANCEIRAS E OPÇÕES DE EDIÇÃO.
//Traz informações da tabela filtrar pelo condominio
$(document).ready(function () {
    $.ajax({
        url: '/PHP/Condominios/acoListarCondominiosPesquisa.php',
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            var select = $('#condominio_id5'); // Ajuste conforme o índice da coluna
            if (Array.isArray(data)) { // Verifica se é um array
                select.empty(); // Limpa o select
                select.append('<option value="">Selecione um condomínio</option>');
                data.forEach(function (condominio) {
                    select.append('<option value="' + condominio.id + '">' + condominio.nome + '</option>');
                });
            } else {
                console.error('Formato de dados inesperado:', data);
            }
        },
        error: function (error) {
            console.log('Não foi possível obter os condomínios', error);
        }
    });
    var table = $('#table2').DataTable({
        // Configurações do DataTables
        "paging": true,
        "searching": true,
        "ajax": {
            "url": "/PHP/Financeiro/acoListarTransacoes.php",
            "dataSrc": "data",
            "data": function (d) {
                // Envia o nome do condomínio selecionado
                d.condominio_id = $('#condominio_id6').val();
            }
        },
        "columns": [
            { "data": "id" },
            { "data": "tipo_transacao" },
            { "data": "condominio_id" },
            { "data": "nome_morador" },
            { "data": "categoria" },
            { "data": "descricao" },
            { "data": "valor_recebido" },
            { "data": "valor_receber"},
            { "data": "data_transacao" },
            { "data": "status_pagamento" },
            { "data": "data_vencimento" },
            { "data": "data_pagamento" },
            {
                "data": null,
                "defaultContent": "",
                "render": function (data, type, row, meta) {
                    if (type === 'display') {
                        return "<button class='btn btn-outline-primary btn-sm' onclick='window.location.href=\"/acoAlterarDadosFinanceiros.html?id=" + row.id + "\"'>Editar</button><br> ";
                    }
                    return data;
                },
                "orderable": false
            }
        ]
        // Outras opções do DataTables, se necessário
    });

    // Filtragem por coluna - OK
    $('#condominio_id5').on('change', function () {
        table.ajax.reload();
    });

});

//*** 3° - SAíDAS - Retorna lista de condominios para cadastro de receita Saidas Financeiras **OFICIAL** ***//
$(document).ready(function () {
    function loadCondominios() {
        $.ajax({
            url: '/PHP/Financeiro/acoBuscaCondominioFin.php', // Este script PHP deve retornar uma lista de condomínios
            type: 'GET',
            dataType: 'json',
            success: function (condominios) {
                const select = $('#condominio_id8');
                select.empty();
                $.each(condominios, function (index, condominio) {
                    select.append(new Option(condominio.nome, condominio.id));
                });
            }
        });
    }

    // Carrega os moradores quando um condomínio é selecionado
    $('#condominio_id8').change(function () {
        var condominioId = $(this).val(); // Pega o ID do condomínio selecionado
        loadMoradores(condominioId); // Carrega os moradores para este condomínio
    });


    $('#formSaidasFin').on('submit', function (e) {
        e.preventDefault();
        const formData = $(this).serialize();

        $.ajax({
            url: '/PHP/Financeiro/acoAdicionarSaidasFin.php',
            type: 'POST',
            data: formData,
            success: function (response) {
                console.log(response);
                // Tratamento de resposta aqui
                // Por exemplo, limpar o formulário e mostrar uma mensagem de sucesso
                $('#formSaidasFin').trigger("reset");
                Swal.fire({
                    icon: 'success',
                    title: 'Sucesso!',
                    text: 'Transação adicionada com sucesso!'
                });
                setTimeout(function () {
                    window.location.href = "/acoCadastroFinanceiro.html";
                }, 2500);
            },
            error: function (xhr, status, error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Erro!',
                    text: 'Erro ao adicionar transação!'
                });
            }
        });
    });

    loadCondominios();

});


//Fluxo de Caixa.
$(document).ready(function () {
    $.ajax({
        url: '/PHP/Financeiro/acoCalculosFluxoCaixa.php',
        type: 'GET',
        success: function (response) {
            // Supondo que o response seja um objeto JSON com os saldos
            $('#saldoMesAnterior').html('Saldo do Mês Anterior: ' + response.saldoMesAnterior);
            $('#saldoAtual').html('Saldo Atual: ' + response.saldoAtual);
        }
    });
});







//Carrega condominios para cadastro de Atividades Administrativas
$(document).ready(function () {
    // Carregar a lista de condomínios
    function loadCondominios() {
        $.ajax({
            url: '/PHP/Financeiro/acoBuscaCondominioFin.php', // Este script PHP deve retornar uma lista de condomínios
            type: 'GET',
            dataType: 'json',
            success: function (condominios) {
                $.each(condominios, function (key, condominio) {
                    $('#condominio_id4').append(new Option(condominio.nome, condominio.id));
                });
            }
        });
    }

    // AJAX para submissão do formulário
    $("#formAtividades").on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            url: '/PHP/Financeiro/acoCadastrarAtividades.php',
            type: 'post',
            data: $(this).serialize(),
            success: function (response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Sucesso!',
                    text: 'Atividade cadastrada com sucesso!'
                });
                alert(response);
            },
            error: function (xhr, status, error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Erro!',
                    text: 'Erro ao cadastrar atividade!'
                });
                alert("Erro ao cadastrar atividade.");
            }

        });
    });

    loadCondominios();
});


//Carrega condominios para cadastro de SAÍDAS Financeiras
$(document).ready(function () {
    // Carregar a lista de condomínios
    function loadCondominios() {
        $.ajax({
            url: '/PHP/Financeiro/acoBuscaCondominioFin.php', // Este script PHP deve retornar uma lista de condomínios
            type: 'GET',
            dataType: 'json',
            success: function (condominios) {
                $.each(condominios, function (key, condominio) {
                    $('#condominio_id7').append(new Option(condominio.nome, condominio.id));
                });
            }
        });
    }

    // AJAX para submissão do formulário
    $("#formSaidas").on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            url: '/PHP/Financeiro/acoCadastrarAtividades.php',
            type: 'post',
            data: $(this).serialize(),
            success: function (response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Sucesso!',
                    text: 'Atividade cadastrada com sucesso!'
                });
                alert(response);
            },
            error: function (xhr, status, error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Erro!',
                    text: 'Erro ao cadastrar atividade!'
                });
                alert("Erro ao cadastrar atividade.");
            }

        });
    });

    loadCondominios();
});

