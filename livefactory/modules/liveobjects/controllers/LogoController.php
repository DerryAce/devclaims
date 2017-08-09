<?php
namespace livefactory\modules\liveobjects\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use livefactory\models\search\CommonModel as SessionVerification;
class LogoController extends Controller
{
	public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }
	public function init(){
		error_reporting(0);
		SessionVerification::checkSessionDestroy();
    	if(!isset(Yii::$app->user->identity->id)){
          $this->redirect(array('/site/login'));
		}
	}
    public function actionIndex()
    {
		if(isset($_FILES['logo']) && !empty($_FILES['logo']['name'])){
			
			move_uploaded_file($_FILES['logo']['tmp_name'],"../logo/logo.png");
		}
        return $this->render('index');
    }
}
