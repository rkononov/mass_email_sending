<?php
$num_emails = $_REQUEST['num_emails'];

$start = get_time();
require_once dirname(__FILE__) . "/../workers/lib/class.phpmailer.php";
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
    send_email($mail);
}
$sent_time = get_time() - $start;
$details = array("sent" => $sent_time);
echo json_encode($details);


function get_time()
{
    return (float)array_sum(explode(' ', microtime()));
}

function send_email($mail)
{
    $mail->AddAddress("whoto@otherdomain.com", "John Doe");
    $mail->Send();
}

?>
