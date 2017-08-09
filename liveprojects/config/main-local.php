<?php

$config = [ 
		'components' => [ 
				'request' => [
						// !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
						'cookieValidationKey' => 'f3obrQ23g0eQVxRrADqS4I5PgdPGAFt9' 
				] 
		] 
];

// added by mohitg to enable gii and debug toolbar
if (true)
{
	// if (!YII_ENV_DEV) {
	// configuration adjustments for 'dev' environment
	/*$config ['bootstrap'] [] = 'debug';
		
	$config ['modules'] ['debug'] ['class'] = 'yii\debug\Module';
	$config ['modules'] ['debug'] ['allowedIPs'] = [ 
			'*' 
	];
	*/
	
	$config ['bootstrap'] [] = 'gii';
	// $config['modules']['gii'] = 'yii\gii\Module';
	$config ['modules'] ['gii'] ['class'] = 'yii\gii\Module';
	
	$config ['modules'] ['gii'] ['generators'] = [ 
			'kartikgii-crud' => [ 
					'class' => 'warrence\kartikgii\crud\Generator' 
			] 
	];

}

return $config;
