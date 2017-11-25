<?php

$body = "HELLOOOOOOOOO";

sendMail($body);

function getUpdates()
{
	


}

function sendMail($body)
{
	require_once 'vendor/autoload.php';

	$gmail_acc = 'squibotics.reporter@gmail.com';
	$password = 'LETmein!2';

	//$to = ['andrew@squibotics.com' => 'Andrew Hopman'];
	$to = ['navid.fanaian@gmail.com' => 'Navid'];

	// Create the Transport
	$transport = (new Swift_SmtpTransport('smtp.gmail.com', 465, 'ssl'))
		->setUsername($gmail_acc)
		->setPassword($password);

	// Create the Mailer using your created Transport
	$mailer = new Swift_Mailer($transport);

	// Create a message
	$message = (new Swift_Message('Squibotics Daily Reporter'))
		->setFrom([$gmail_acc => 'Squibotics Reporter'])
		->setTo($to)
		->setBody($body);

	// Send the message
	$result = $mailer->send($message);
}

?>