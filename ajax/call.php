<?php
ob_start();
header('Access-Control-Allow-Origin: *');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require_once("../classes/db.php");
require_once("../classes/PHPMailer/Exception.php");
require_once("../classes/PHPMailer/PHPMailer.php");
require_once("../classes/PHPMailer/SMTP.php");

$db = new DataBase();
$db->Connect();

$sub = $_POST['subject'];
$msg = $_POST['content'];
$id = $_POST['id'];
$time = $_POST['time'];


$json_array = array();

// $query = $db->Fetch_Array("SELECT * FROM `customer` WHERE `customer_id` = '".$id."'");

// $query['customer_email'];

//move_uploaded_file($_FILES['image']['tmp_name'], '../file/' . $_FILES['image']['name']);

if (empty($msg))
{
	$json_array[] = array(
		'status' => false,
		'messenge' => "Please insert a content!"
	);
	die(json_encode($json_array));
}
if (strlen($msg) < 5)
{
	$json_array[] = array(
		'status' => false,
		'messenge' => "Content is not allowed under 5 characters!"
	);
	die(json_encode($json_array));
}





$act = $_REQUEST["act"];

switch ($act) {
	case 'all':
		$query = $db->Query("SELECT * FROM `customer`");

		while ($row = mysqli_fetch_array($query))
		{
			$mail = new PHPMailer(true);
			$mail->CharSet = 'UTF-8';
			$mail->isSMTP();
			$mail->Host = 'smtp.gmail.com';
			$mail->SMTPAuth = true;
			$mail->Username = 'napngaytrade@gmail.com';
			$mail->Password = 'ubjphvdpybiyhkyz';
			$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
			$mail->Port = 465; 

			$mail->setFrom($row['customer_email'], $sub);
			$mail->addAddress($row['customer_email']);

			$mail->isHTML(true);
			$mail->Subject = $sub;
			$mail->Body = $msg;

			$mail->AltBody = '';
			$mail->addAttachment($_FILES['image']['tmp_name'], $_FILES['image']['name']);
			
			if ($mail->send())
			{

				$time_res = time() - ($time/1000);

				$file = "TimeAVG.log";
				$fh = fopen($file, 'a') or die("cant open file");
				fwrite($fh, $row['customer_email']."|".$time_res."|".date('m/d/Y H:i:s', $time_res));
				fwrite($fh, "\r\n");
				fclose($fh);

				$json_array[] = array(
					'status' => true,
					'messenge' => $row['customer_email']." send success!"
				);
			}
			else
			{
				$time_end = time();

				$json_array[] = array(
					'status' => false,
					'messenge' => $row['customer_email']." send failed!"
				);
			}
			$mail->clearAddresses();
			$mail->clearAttachments();
			
		}


		break;
	case 'select':

		$row = $db->Fetch_Array("SELECT * FROM `customer` WHERE `customer_id` = '".$id."'");
		$mail = new PHPMailer(true);
		$mail->CharSet = 'UTF-8';
		$mail->isSMTP();
		$mail->Host = 'smtp.gmail.com';
		$mail->SMTPAuth = true;
		$mail->Username = 'napngaytrade@gmail.com';
		$mail->Password = 'ubjphvdpybiyhkyz';
		$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
		$mail->Port = 465; 

		$mail->setFrom($row['customer_email'], $sub);
		$mail->addAddress($row['customer_email']);

		$mail->isHTML(true);
		$mail->Subject = $sub;
		$mail->Body = $msg;

		$mail->AltBody = '';
		$mail->addAttachment($_FILES['image']['tmp_name'], $_FILES['image']['name']);
		
		if ($mail->send())
		{
			$time_res = time() - ($time/1000);

			$file = "TimeAVG.log";
			$fh = fopen($file, 'a') or die("cant open file");
			fwrite($fh, $row['customer_email']."|".$time_res."|".date('m/d/Y H:i:s', $time_res));
			fwrite($fh, "\r\n");
			fclose($fh);

			$json_array[] = array(
				'status' => true,
				'messenge' => $row['customer_email']." send success!"
			);
		}
		else
		{
			$json_array[] = array(
				'status' => false,
				'messenge' => $row['customer_email']." send failed!"
			);
		}
		$mail->clearAddresses();
		$mail->clearAttachments();

	break;
	
	default:
		# code...
	break;
}
echo json_encode($json_array);

ob_flush();
?>