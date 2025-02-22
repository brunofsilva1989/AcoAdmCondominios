<?php
include_once __DIR__ . "/../../config/db.php";
require __DIR__ . "/../../vendor/autoload.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);

    // Verificar se o e-mail existe no banco
    $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);

    if ($stmt->rowCount() == 0) {
        echo json_encode(["status" => "erro", "mensagem" => "E-mail não encontrado!"]);
        exit;
    }

    // Gerar token curto (Apenas 8 caracteres alfanuméricos)
    $token = substr(bin2hex(random_bytes(16)), 0, 8);
    $expira_em = date('Y-m-d H:i:s', strtotime('+1 hour'));

    // Inserir o token no banco (substituir a coluna token se já existir)
    $stmt = $pdo->prepare("INSERT INTO password_resets (email, token, expira_em) VALUES (?, ?, ?) 
                          ON DUPLICATE KEY UPDATE token = VALUES(token), expira_em = VALUES(expira_em)");
    $stmt->execute([$email, $token, $expira_em]);

    // Configurar PHPMailer
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.hostinger.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'site@acoadmcondominios.com.br';
        $mail->Password = 'SiteAco2024@';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;

        // Definir cabeçalhos corretamente
        $mail->CharSet = 'UTF-8';
        $mail->Encoding = 'base64';

        // Configuração do e-mail
        $mail->setFrom('site@acoadmcondominios.com.br', 'Equipe Aco Administração');
        $mail->addAddress($email);
        $mail->Subject = '🔒 Recuperação de Senha';

        // Link formatado
        $link = "http://localhost/acoResetarSenha.html?token=" . $token;

        // Corpo do e-mail em HTML melhor formatado
        $mail->isHTML(true);
        $mail->Body = "
            <div style='font-family: Arial, sans-serif; color: #333; padding: 20px; max-width: 600px;'>
                <h2 style='color: #007bff;'>🔐 Recuperação de Senha</h2>
                <p>Olá,</p>
                <p>Recebemos uma solicitação para redefinir sua senha. Clique no botão abaixo para continuar:</p>
                <p style='text-align: center;'>
                    <a href='$link' style='background-color: #007bff; color: white; padding: 10px 15px; text-decoration: none; border-radius: 5px; display: inline-block;'>
                        Redefinir Senha
                    </a>
                </p>
                <p>Ou copie e cole o seguinte link no navegador:</p>
                <p style='background: #f4f4f4; padding: 10px; word-wrap: break-word;'>
                    <a href='$link'>$link</a>
                </p>
                <p>Se você não solicitou essa alteração, ignore este e-mail.</p>
                <hr>
                <p style='font-size: 12px; color: #777;'>Equipe Aco Administração</p>
            </div>
        ";

        // Enviar e-mail
        if ($mail->send()) {
            echo json_encode(["status" => "sucesso", "mensagem" => "E-mail de recuperação enviado!"]);
        } else {
            echo json_encode(["status" => "erro", "mensagem" => "Erro ao enviar e-mail: " . $mail->ErrorInfo]);
        }
    } catch (Exception $e) {
        echo json_encode(["status" => "erro", "mensagem" => "Erro: " . $e->getMessage()]);
    }
}
?>
