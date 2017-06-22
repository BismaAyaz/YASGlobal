<?php

require_once 'PHPMailer/PHPMailerAutoload.php';

define('GUSER', 'bisma@ayazahmed.com'); // GMail username
define('GPWD', 'Bisma2015'); // GMail password
DEFINE('WEBSITE_URL', 'http://localhost');


function smtpmailer($to, $from, $from_name, $subject, $body) { 
	global $error;
	$mail = new PHPMailer();  // create a new object
	$mail->IsSMTP(); // enable SMTP
	$mail->SMTPDebug = 0;  // debugging: 1 = errors and messages, 2 = messages only
	$mail->SMTPAuth = true;  // authentication enabled
	$mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
	$mail->Host = 'srv10.hosterpk.com'; //smtp.gmail.com';
	$mail->Port = 465; //465; 
	$mail->Username = GUSER;  
	$mail->Password = GPWD;           
	$mail->SetFrom($from, $from_name);
	$mail->Subject = $subject;
	$mail->Body = $body;
	$mail->AddAddress($to);
	if(!$mail->Send())
	{
		$error = 'Mail error: '.$mail->ErrorInfo; 
		echo $error;
		return false;
	} else {
		$error = 'Message sent!';
		return true;
	}
}

?>
<?php
echo "Sending Email";
 $message = "Checking Email Alert";
    if (smtpmailer('bisma.ayaz@yahoo.com', 'techrisersnedcis@gmail.com', 'YAS | Alert', 'Alert Email Checking', $message)) {
	$msg='<div class="success">A confirmation email
has been sent to  </div>';}
?>

