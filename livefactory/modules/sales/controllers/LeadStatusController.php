<?php

namespace livefactory\modules\sales\controllers;

use Yii;
use livefactory\models\LeadStatus;
use livefactory\models\search\LeadStatus as LeadStatusSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use livefactory\models\search\CommonModel as SessionVerification;
/**
 * LeadStatusController implements the CRUD actions for LeadStatus model.
 */
class LeadStatusController extends Controller
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
		SessionVerification::checkSessionDestroy();
    	if(!isset(Yii::$app->user->identity->id)){
          $this->redirect(array('/site/login'));
		}
		if(Yii::$app->user->identity->user_role_id !='1'){
          $this->redirect(array('/site/index'));
		}
	}
    /**
     * Lists all LeadStatus models.
     * @return mixed
     */
    public function actionIndex()
    {
		extract(LeadStatus::find()->select("Max(sort_order) max_sort_order")->asArray()->one());
		//var_dump();
		if(!empty($_REQUEST['actionType'])){
			//$model = $this->findModel($_REQUEST['sort_order_update']);
			$statusId = $_REQUEST['sort_order_update'];
			$sortValue = $_REQUEST['sort_order_update'.$statusId];	
			//var_dump($statusId." ".$sortValue);
			if($_REQUEST['actionType'] !='Down'){
				if($sortValue !='1'){
					$minusValue = intval($sortValue)-1;
					$Update= LeadStatus::find()->where(['sort_order' => $sortValue])->one();
					$Update1= LeadStatus::find()->where(['sort_order' => $minusValue])->one();
					$Update->sort_order=$minusValue;
					$Update->update();
					
					$Update1->sort_order=$sortValue;
					$Update1->update();
				}
			}else{
				if($max_sort_order !=$sortValue){
					$plusValue = intval($sortValue)+1;
					$Update= LeadStatus::find()->where(['sort_order' => $sortValue])->one();
					$Update1= LeadStatus::find()->where(['sort_order' => $plusValue])->one();
					$Update->sort_order=$plusValue;
					$Update->update();
					$Update1->sort_order=$sortValue;
					$Update1->update();
				}
			}
		}
        $searchModel = new LeadStatusSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Displays a single LeadStatus model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
        return $this->redirect(['view', 'id' => $model->id]);
        } else {
        return $this->render('view', ['model' => $model]);
}
    }

    /**
     * Creates a new LeadStatus model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new LeadStatus;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing LeadStatus model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing LeadStatus model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the LeadStatus model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return LeadStatus the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = LeadStatus::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
