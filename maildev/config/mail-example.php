<?php
/**
 * @author  Yogesh Maharjan
 * @website https://yogeshmaharjan.com.np
 * 
 * The configs for the maildev library.
 *
 * Setup your development and production email configurations from here.
 * 
 */

global $mailConfigs;

$mailConfigs = [

	//The development mail configs
	'DEV' => [
		'MAIL_DRIVER'		=> 'smtp',
		'MAIL_HOST' 		=> 'smtp.mailtrap.io',
		'MAIL_PORT'			=> 2525,
		'MAIL_USERNAME'		=> 'asfdadfadf',
		'MAIL_PASSWORD'		=> 'asdfadfadf',
		'MAIL_ENCRYPTION'	=> 'null',
		'MAIL_FROM_ADDRESS'	=> 'user@example.com',
		'MAIL_FROM_NAME'	=> "From name"
	],

	//the production mail configs
	'PRO' => [
		'MAIL_DRIVER'		=> 'smtp',
		'MAIL_HOST' 		=> 'dev.host.com',
		'MAIL_PORT'			=> 587,
		'MAIL_USERNAME'		=> 'sender@email.com',
		'MAIL_PASSWORD'		=> 'thefreakingpassword',
		'MAIL_ENCRYPTION'	=> '',
		'MAIL_FROM_ADDRESS'	=> 'user@example.com',
		'MAIL_FROM_NAME'	=> "From name"
	]

];
