<?php
require __DIR__ . "/../../vendor/autoload.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);

try {
    // Configurações do servidor SMTP
    $mail->isSMTP();
    $mail->SMTPDebug = 2; // Exibe mensagens detalhadas da conexão
    $mail->Debugoutput = 'html'; // Formata a saída do debug em HTML
    $mail->Host = 'smtp.hostinger.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'site@acoadmcondominios.com.br'; // Substitua pelo seu e-mail
    $mail->Password = 'SiteAco2024@'; // Se usar Gmail, gere uma senha de aplicativo
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;

    // Configuração do e-mail
    $mail->setFrom('site@acoadmcondominios.com.br', 'Equipe Aco Administração de Condomínios');
    $mail->addAddress('destinatario@gmail.com');
    $mail->Subject = 'Teste de E-mail via PHPMailer';
    $mail->Body = 'Este é um teste de envio de e-mail via PHPMailer usando o Composer.';

    // Enviar e-mail
    if ($mail->send()) {
        echo "E-mail enviado com sucesso!";
    } else {
        echo "Erro ao enviar e-mail: " . $mail->ErrorInfo;
    }
} catch (Exception $e) {
    echo "Erro: " . $e->getMessage();
}
?>
