//VERIFICA SE O USUÁRIO ESTÁ LOGADO
$.ajax({
    url: '/PHP/Login/verificarLogin.php',
    type: 'GET',
    dataType: 'json',
    success: function (response) {
        if (!response.logado) {
            window.location.href = '/acoLoginPainel.html'; // Redireciona para a página de login
        }
    }
});

//LOGOUT - sair do sistema
$('#logoutButton').click(function (e) {
    e.preventDefault();
    $.ajax({
        url: '/PHP/Login/logout.php',
        type: 'POST',
        success: function () {
            window.location.href = '/acoLoginPainel.html'; // Redireciona para a página de login após o logout
        }
    });
});

