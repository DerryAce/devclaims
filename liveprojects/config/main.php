<?php

/*

 *     The contents of this file are subject to the Initial

 *     Developer's Public License Version 1.0 (the "License");

 *     you may not use this file except in compliance with the

 *     License. You may obtain a copy of the License at

 *     http://www.liveobjects.org/livecrm/license.php

 *

 *     Software distributed under the License is distributed on

 *     an "AS IS" basis, WITHOUT WARRANTY OF ANY KIND, either

 *     express or implied.  See the License for the specific

 *     language governing rights and limitations under the License.

 *

 *

 *  The Original Code was created by Mohit Gupta (mohit.gupta@liveobjects.org) for LiveObjects Technologies Pvt. Ltd. (contact@liveobjects.org)

 *

 *  Copyright (c) 2014 - 2015 LiveObjects Technologies Pvt. Ltd.

 *  All Rights Reserved.

 *

 *  This translation and editing was done by Mohit Gupta of LiveObjects

 *

 */



$params = array_merge ( require (__DIR__ . '/../../livefactory/config/params.php'), require (__DIR__ . '/../../livefactory/config/params-local.php'), require (__DIR__ . '/params.php'), require (__DIR__ . '/params-local.php') );



use kartik\datecontrol\Module;



return [ 



		'id' => 'app-liveprojects',



		'basePath' => dirname ( __DIR__ ),



		'controllerNamespace' => 'liveprojects\controllers',



		'bootstrap' => [ 



				// 'log',



				// 'debug' 



		],



		



		



		



		'modules' => [



				



				// added by mohitg



				'pmt' => [ 



						'class' => 'livefactory\modules\pmt\Module' 



				],



				



				'customer' => [ 



						'class' => 'livefactory\modules\customer\Module' 



				],



				



				'liveobjects' => [ 



						'class' => 'livefactory\modules\liveobjects\Module' 



				],



				



				'user' => [ 



						'class' => 'livefactory\modules\user\Module' 



				],



				'company' => [ 



						'class' => 'livefactory\modules\company\Module' 



				],



				



				// modules end



				

		

				'debug' => [ 



						'class' => 'yii\debug\Module',



						'allowedIPs' => ['*']



				],

		



				

			

				'gii' => [ 



						'class' => 'yii\gii\Module',



						'allowedIPs' => [ 



								'127.0.0.1',



								'::1',



								'192.168.1.*',



								'*.*.*.*',



								'182.64.168.158' 



						] 



				],

	



				



				// adjust this to your needs



				'dynagrid' => [ 



						'class' => '\kartik\dynagrid\Module' 



				],



				'gridview' => [ 



						'class' => '\kartik\grid\Module' 



				],



				



				// enter optional module parameters below - only if you need to



				// use your own export download action or custom translation



				// message source



				// 'downloadAction' => 'gridview/export/download',



				// 'i18n' => []

				

				'datecontrol' => [ 



						'class' => '\kartik\datecontrol\Module',



						



						// format settings for displaying each date attribute



						'displaySettings' => [ 


								 
								Module::FORMAT_DATE => 'php:D j M Y',



								//Module::FORMAT_TIME => 'H:i:s',



								Module::FORMAT_DATETIME => 'php:D j M Y' 



						],



						'autoWidgetSettings' => [ 



								Module::FORMAT_DATE => [ 



										'type' => 2,



										'pluginOptions' => [ 



												'autoclose' => true 



										] 



								], // example



								Module::FORMAT_DATETIME => [ 



										'type' => 2,



										'pluginOptions' => [ 



												'autoclose' => true 



										] 



								], // setup if needed



								Module::FORMAT_TIME => [ ] 



						], // setup if needed



						  



						// format settings for saving each date attribute



						'saveSettings' => [ 



								Module::FORMAT_DATE => 'dd/M/yyyy', // saves as unix timestamp



								//Module::FORMAT_TIME => 'H:i:s',



								Module::FORMAT_DATETIME => 'dd/M/yyyy' 



						],



						



						// automatically use kartik\widgets for each of the above formats



						'autoWidget' => true,



						



						// 'autoClose' => true,



						



						// custom widget settings that will be used to render the date input instead of kartik\widgets,



						// this will be used when autoWidget is set to false at module or widget level.



						'widgetSettings' => [ 



								Module::FORMAT_DATE => [ 



										'class' => 'yii\jui\DatePicker',



										'options' => [ 



												'options' => [ 



														'class' => 'form-control' 



												],



												'clientOptions' => [ 



														'dateFormat' => 'dd-mm-yy' 



												] 



										] 



								] 



						] 



				] 



		],



		'components' => [ 



				'user' => [ 



						'identityClass' => 'livefactory\models\User',



						'enableAutoLogin' => true 



				],



				'log' => [ 



						'traceLevel' => YII_DEBUG ? 3 : 0,



						'targets' => [ 



								[ 



										'class' => 'yii\log\FileTarget',



										'levels' => [ 



												'error',



												'warning' 



										] 



								] 



						] 



				],

				

		



				'errorHandler' => [ 



						'errorAction' => 'site/error' 



				]



		],



		'params' => $params 



];

