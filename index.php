<?php 

define('MAIL_ENV','DEV');

require __DIR__.'/maildev/libs/Mailer.php';

$mailer = new Mailer();

$mailer->enableDebug(2);

$mailer->setSubject("Test Email");
$mailer->setEmailContent("This is a test email!!!");
$mailer->AddAddress("metal4yogesh@gmail.com",'Yogesh Maharjan');

echo "<pre>";
var_dump($mailer->send());
var_dump($mailer->getMailError());
die;
