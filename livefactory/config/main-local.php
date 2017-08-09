<?php
return [ 
		'components' => [ 
				'db' => [ 
						'class' => 'yii\db\Connection',
						'dsn' => 'mysql:host=localhost;dbname=livecrm',
						'username' => 'root',
						'password' => '',
						'charset' => 'utf8',
						/*
						'class' => 'yii\db\Connection',
						'dsn' => 'mysql:host=localhost;dbname=livecrm',
						'username' => 'root',
						'password' => '',
						'charset' => 'utf8'
						*/
				],
				'request' => [
						// !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
						'enableCookieValidation' => true,
						'enableCsrfValidation' => true,
						'cookieValidationKey' => 'f3obrQ23g0eQVxRrADqS4I5PgdPGAFt9' 
				],
				'mailer' => [ 
						'class' => 'yii\swiftmailer\Mailer',
						'viewPath' => '@livefactory/mail',
							
						// send all mails to a file by default. You have to set
						// 'useFileTransport' to false and configure a transport
						// for the mailer to send real emails.
						'useFileTransport' => true,
						/*'transport' => [
							'class' => 'Swift_SmtpTransport',
							'host' => 'smtp.yahoo.in',
							'username' => 'shaikh.mufiz@yahoo.in',
							'password' => 'kabir123',
							'port' => '587',
							'encryption' => 'ssl',
						],*/  
				] ,
		] 
];


