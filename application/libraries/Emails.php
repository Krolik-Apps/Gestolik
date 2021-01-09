<?php 
// ================================================================================
/*  library para enviar emails através do PHPMailer
    NOTAS:
    1. O PHPMailer tem que estar na pasta [base]/assets/phpmailer
    2. Definir corretamente as configurações de email
    3. $destinatarios é um array com os contactos de email dos destinatários
    4. O método enviar() retorna TRUE (enviado) ou FALSE (aconteceu um erro no envio)
*/
// ================================================================================
defined('BASEPATH') OR exit('URL inválida.');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Emails{

    // ============================================================================
    public function enviar($nome, $remetente, $destinatario, $assunto, $mensagem){
        require 'assets/PHPMailer/src/Exception.php';
        require 'assets/PHPMailer/src/PHPMailer.php';
        require 'assets/PHPMailer/src/SMTP.php';
         
        $mail = new PHPMailer(true);                                // Passing `true` enables exceptions
        $enviada = false;
        try {
            //Configurações do servidor
            $mail->IsSMTP();
            $mail->SMTPDebug = 0;
            $mail->Debugoutput = 'html';
            $mail->CharSet = 'UTF-8';
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = 'ssl';
            $mail->Host = 'krolik.pt';
            $mail->Port = '465';
            $mail->Username = 'info@krolik.pt';
            $mail->Password = 'Satierf??123';
            $mail->Subject = $assunto;
            $mail->Body = $mensagem;
            $mail->IsHTML(true);
            $mail->From = $remetente;
            $mail->FromName = $nome;
            $mail->AddAddress($destinatario); //E-Mail para onde vai a mensagem

            $enviada = $mail->send();
            
        } catch (Exception $e) {
            $enviada = false;
        }
        return $enviada;
    }
}

?>