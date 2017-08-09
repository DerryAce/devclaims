<?php

namespace livefactory\modules\sales\controllers;

use Yii;
use livefactory\models\LeadPriority;
use livefactory\models\search\LeadPriority as LeadPrioritySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use livefactory\models\search\CommonModel as SessionVerification;
/**
 * LeadPriorityController implements the CRUD actions for LeadPriority model.
 */
class LeadPriorityController extends Controller
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
     * Lists all LeadPriority models.
     * @return mixed
     */
    public function actionIndex()
    {
		extract(LeadPriority::find()->select("Max(sort_order) max_sort_order")->asArray()->one());
		//var_dump();
		if(!empty($_REQUEST['actionType'])){
			//$model = $this->findModel($_REQUEST['sort_order_update']);
			$statusId = $_REQUEST['sort_order_update'];
			$sortValue = $_REQUEST['sort_order_update'.$statusId];	
			//var_dump($statusId." ".$sortValue);
			if($_REQUEST['actionType'] !='Down'){
				if($sortValue !='1'){
					$minusValue = intval($sortValue)-1;
					$Update= LeadPriority::find()->where(['sort_order' => $sortValue])->one();
					$Update1= LeadPriority::find()->where(['sort_order' => $minusValue])->one();
					$Update->sort_order=$minusValue;
					$Update->update();
					
					$Update1->sort_order=$sortValue;
					$Update1->update();
				}
			}else{
				if($max_sort_order !=$sortValue){
					$plusValue = intval($sortValue)+1;
					$Update= LeadPriority::find()->where(['sort_order' => $sortValue])->one();
					$Update1= LeadPriority::find()->where(['sort_order' => $plusValue])->one();
					$Update->sort_order=$plusValue;
					$Update->update();
					$Update1->sort_order=$sortValue;
					$Update1->update();
				}
			}
		}
        $searchModel = new LeadPrioritySearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Displays a single LeadPriority model.
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
     * Creates a new LeadPriority model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new LeadPriority;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing LeadPriority model.
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
     * Deletes an existing LeadPriority model.
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
     * Finds the LeadPriority model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return LeadPriority the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = LeadPriority::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
