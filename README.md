# maildev
A simple PHP library to send mail. Developed on top of popular PHPMailer class library.

This library allows you to set up development and production environment to send emails.

### Simple Example

Create a index.php file with following contents.

```php
<?php 

//Set your mail environment, DEV or PRO
define('MAIL_ENV','PRO');

//require the library
require __DIR__.'/maildev/libs/Mailer.php';

//initialize the mailer class
$mailer = new Mailer();

//set subject
$mailer->setSubject("Test Email");

//set the content
$mailer->setEmailContent("This is a test email!!!");

//set the receiver
$mailer->AddAddress("receiver@example.com",'Bruce Wayne');

//send the email
$mailer->send()
```

