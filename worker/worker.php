<?php
require __DIR__ . '/vendor/autoload.php';
use Pheanstalk\Pheanstalk;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$pheanstalk = Pheanstalk::create('host.docker.internal');
$pheanstalk->watch('email');

while(true) {
    $job = $pheanstalk->reserveWithTimeout(5);

    if ($job) {
        $jobPayload = $job->getData();

        SendEmail(json_decode($jobPayload, true));
        $pheanstalk->touch($job);
        $pheanstalk->delete($job);
    }
    if (! $job) {
        continue;
    }
}

function SendEmail($data)
{
    $mail = new PHPMailer;
    $mail->isSMTP();
    $mail->SMTPDebug = 2;
    $mail->Debugoutput = 'html';
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 587;
    $mail->SMTPSecure = 'tls';
    $mail->SMTPAuth = true;
    $mail->Username = "aalexanderkevin.nonton@gmail.com";
    $mail->Password = base64_decode('VGVzdEVtYWlsMTIz');
    $mail->setFrom('aalexanderkevin@noreply.com', 'Alexander Kevin');
    $mail->addAddress($data['sendTo']);
    $mail->Subject = 'Send Email via PHP';
    $mail->msgHTML($data['message']);
    
    if (!$mail->send()) error_log("Mailer Error: " . $mail->ErrorInfo);
    else error_log("Message sent!");
    
    InsertDb($data);
}

function InsertDb($data)
{
    try {
        $conn = pg_connect("host=host.docker.internal port=5432 dbname=email user=postgres password=postgres");
    } catch (\Throwable $th) {
        error_log("Cannnot connect to db, check your connection" . $th);
        return false;
    }
    $email = $data["sendTo"];
    $message = $data["message"];
    $query = "INSERT INTO emails (sendTo, content) VALUES ('$email', '$message') ";
    $res = pg_query($conn, $query );
    if (! $res) {
        return false;
    }
    error_log('Success insert to dB');
    return true;
}