<?php

namespace livefactory\modules\liveobjects\controllers;

use Yii;
use yii\web\Controller;
use livefactory\models\ConfigItem;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use livefactory\models\search\CommonModel as SessionVerification;
/**
 * StatusController implements the CRUD actions for Status model.
 */
class ThemeController extends Controller
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
		if(Yii::$app->user->identity->user_role_id !='1'){
          $this->redirect(array('/site/index'));
		}
	}
    /**
     * Lists all Status models.
     * @return mixed
     */
    public function actionIndex()
    {
       // $searchModel = new StatusSearch;
        $dataProvider = ConfigItem::find()->where("config_item_description='theme'")->asArray()->all();
		$dataProviderColor = ConfigItem::find()->where("config_item_description='theme_color'")->asArray()->all();
		if($_REQUEST['ids']){
			$ids=	$_REQUEST['ids'];
			foreach($ids as $id){
				$active=$_REQUEST['active'.$id];
				$updateConfig = ConfigItem::findOne($id);
				$updateConfig->active = $active;
				$updateConfig->save();
			}
			if($_REQUEST['color']){
				$updateConfig = ConfigItem::findOne($_REQUEST['color']);
				$updateConfig->active = 1;
				$updateConfig->save();
				$connection = \Yii::$app->db;
				$sql="update lot_config_item set active='0' where id !=$_REQUEST[color] and config_item_description='theme_color'";
				$connection->createCommand($sql)->execute();
			}
			$reload='yes';
			return $this->render('index', [
				'dataProvider' => $dataProvider,
				'dataProviderColor'=>$dataProviderColor,
				'reload'=>$reload
			]);
		}
        return $this->render('index', [
            'dataProvider' => $dataProvider,
				'dataProviderColor'=>$dataProviderColor
        ]);
    }
}
