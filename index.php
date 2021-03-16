<?php  
    die;
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    //Load Composer's autoloader
    require 'vendor/autoload.php';

    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();

    // print_r($_ENV['MAIL_HOST']);
    // print_r($_ENV['MAIL_USERNAME']);
    // print_r($_ENV['MAIL_PASSWORD']);
    // print_r($_ENV['MAIL_PORT']);

    // die;

    $templateHTML = file_get_contents('./template-email.html', true);

    $mpdf->fontdata = array(
        "open-sans" => array(		'
            R' => "OpenSans-Regular.ttf",
            'B' => "OpenSans-Bold.ttf",
            'I' => "OpenSans-Italic.ttf",
            'BI' => "OpenSans-BoldItalic.ttf",
        ),
    );
    $mpdf = new \Mpdf\Mpdf();
    $mpdf->AddPage('L');
    $mpdf->WriteHTML($templateHTML);
    $mpdf->Output('certificados/filename.pdf','F');
    
    $mail = new PHPMailer(true);
    try {
        //Server settings
        $mail->SMTPDebug = 1;                    
        $mail->isSMTP();                                           
        $mail->Host       = $_ENV['MAIL_HOST'];                    
        $mail->SMTPAuth   = true;                                 
        $mail->Username   = $_ENV['MAIL_USERNAME'];                   
        $mail->Password   = $_ENV['MAIL_PASSWORD'];                        
        $mail->SMTPSecure = $_ENV['MAIL_ENCRYPTION'];     
        $mail->Port       = $_ENV['MAIL_PORT'];                                  
        
        //Recipients
        $mail->setFrom($_ENV['email'], 'Mailer');
        $mail->addAddress('henrique.almeida.moura@gmail.com', 'Henrique');     //Add a recipient
    
        //Attachments
        $mail->addAttachment(__DIR__ . '/certificados/filename.pdf', 'filename.pdf');    //Optional name
    
        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Agradeç';
        $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
    
        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }

?>