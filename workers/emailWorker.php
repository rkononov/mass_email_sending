<?php
require_once dirname(__FILE__) . "/lib/class.phpmailer.php";
require_once dirname(__FILE__) . "/lib/class.smtp.php";

$args = getArgs();

print_r($args);

$payload = $args['payload'];
$num_emails = $payload->num_emails;
$mail = new PHPMailer();

$mail->IsSMTP();

$mail->SMTPAuth = true;
$mail->Host = "mailtrap.io";
$mail->Port = 2525;
$mail->Username = "ironio";
$mail->Password = "50b28074959b51ca";

$mail->SetFrom('name@yourdomain.com', 'First Last');

$mail->Subject = "PHPMailer Mailtrap Test";

$mail->MsgHTML("Hello");

for ($i = 1; $i <= $num_emails; $i++)
{
    $mail->AddAddress("whoto@otherdomain.com", "John Doe");
    $mail->Send();
}
?>
