<?php

namespace livefactory\modules\pmt\controllers;

use Yii;
use livefactory\models\TaskStatus;
use livefactory\models\search\TaskStatus as TaskStatusSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use livefactory\models\search\CommonModel as SessionVerification;
/**
 * TaskStatusController implements the CRUD actions for TaskStatus model.
 */
class TaskStatusController extends Controller
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
     * Lists all TaskStatus models.
     * @return mixed
     */
    public function actionIndex()
    {
		extract(TaskStatus::find()->select("Max(sort_order) max_sort_order")->asArray()->one());
		//var_dump();
		if($_REQUEST['actionType']){
			//$model = $this->findModel($_REQUEST['sort_order_update']);
			$statusId = $_REQUEST['sort_order_update'];
			$sortValue = $_REQUEST['sort_order_update'.$statusId];	
			//var_dump($statusId." ".$sortValue);
			if($_REQUEST['actionType'] == 'Up'){
				if($sortValue !='1' && $sortValue != ''){
					$minusValue = intval($sortValue)-1;
					$taskUpdate= TaskStatus::find()->where(['sort_order' => $sortValue])->one();
					$taskUpdate1= TaskStatus::find()->where(['sort_order' => $minusValue])->one();
					$taskUpdate->sort_order=$minusValue;
					$taskUpdate->update();
					
					$taskUpdate1->sort_order=$sortValue;
					$taskUpdate1->update();
				}
			}elseif($_REQUEST['actionType'] == 'Down'){
				if($max_sort_order !=$sortValue && $sortValue != ''){
					$plusValue = intval($sortValue)+1;
					$taskUpdate= TaskStatus::find()->where(['sort_order' => $sortValue])->one();
					$taskUpdate1= TaskStatus::find()->where(['sort_order' => $plusValue])->one();
					$taskUpdate->sort_order=$plusValue;
					$taskUpdate->update();
					$taskUpdate1->sort_order=$sortValue;
					$taskUpdate1->update();
				}
			}
		}
        $searchModel = new TaskStatusSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Displays a single TaskStatus model.
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
     * Creates a new TaskStatus model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TaskStatus;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing TaskStatus model.
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
     * Deletes an existing TaskStatus model.
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
     * Finds the TaskStatus model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TaskStatus the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TaskStatus::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
