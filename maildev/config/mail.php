<?php

global $mailConfigs;

$mailConfigs = [

	'DEV' => [
        'MAIL_DRIVER'       => 'smtp',            
        'MAIL_HOST'       => 'mailgate.franklite.co.uk',
        'MAIL_PORT'         => 25,
        'MAIL_USERNAME'     => 'noreply@franklite.co.uk',
        'MAIL_PASSWORD'     => 'Tennis2021@',
        'MAIL_ENCRYPTION'   => 'null',
        'MAIL_FROM_ADDRESS' => 'noreply@franklite.co.uk',
        'MAIL_FROM_NAME'    => "Test"
    ]

];
