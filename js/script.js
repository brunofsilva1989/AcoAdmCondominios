// SCRIPT PARA SEGURANÇA DOS COOKIES DO SITE
const cookieBanner = document.getElementById('cookie-banner');
const acceptCookies = document.getElementById('accept-cookies');
const declineCookies = document.getElementById('decline-cookies');

// Verificar se os cookies já foram aceitos ou recusados
if (!localStorage.getItem('cookiesAccepted') && !localStorage.getItem('cookiesDeclined')) {
    cookieBanner.style.display = 'block';
}

acceptCookies.onclick = () => {
    localStorage.setItem('cookiesAccepted', 'true');
    cookieBanner.style.display = 'none';
};

declineCookies.onclick = () => {
    localStorage.setItem('cookiesDeclined', 'true');
    cookieBanner.style.display = 'none';
};


/*Botao seleciona Plano ao clicar no botão Solicitar Proposta*/
document.addEventListener('DOMContentLoaded', function () {
    // Associar os botões aos valores do plano
    const planButtons = {
        'btnEssencial': 'Essencial',
        'btnPremium': 'Premium',
        'btnMaster': 'Master'
    };

    for (const btnId in planButtons) {
        const button = document.getElementById(btnId);
        const planValue = planButtons[btnId];

        button.addEventListener('click', function () {
            // Aqui você pode adicionar o código para abrir o modal, se necessário
            // ...

            // Pré-selecionar o valor do plano no campo de seleção
            const selectElement = document.getElementById('plan');
            selectElement.value = planValue;
        });
    }
});



