<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';


function SendMail($fm = null, $sub = null, $cnt = null, $att = null, $n_file = null)
{
	$mail = new PHPMailer(true);
	$mail->CharSet = 'UTF-8';
	$mail->isSMTP();
	$mail->Host = 'smtp.gmail.com';
	$mail->SMTPAuth = true;
	$mail->Username = 'napngaytrade@gmail.com';
	$mail->Password = 'ubjphvdpybiyhkyz';
	$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
	$mail->Port = 587; 

	$mail->setFrom("tranlongit1007@gmail.com", $sub);
	$mail->addAddress("tranlongit1007@gmail.com");

	$mail->isHTML(true);
	$mail->Subject = $sub;
	$mail->Body = $cnt;

	$mail->AltBody = '';
	$mail->addAttachment($att, $n_file);

	if ($mail->send())
	{
		return true;
	}
	else
	{
		return false;
	}
	$mail->clearAddresses();
	$mail->clearAttachments();
}

?>