<?php

namespace livefactory\modules\pmt\controllers;

use Yii;
use livefactory\models\ProjectType;
use livefactory\models\search\ProjectType as ProjectTypeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use livefactory\models\search\CommonModel as SessionVerification;
/**
 * ProjectTypeController implements the CRUD actions for ProjectType model.
 */
class ProjectTypeController extends Controller
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
     * Lists all ProjectType models.
     * @return mixed
     */
    public function actionIndex()
    {
		extract(ProjectType::find()->select("Max(sort_order) max_sort_order")->asArray()->one());

		if($_REQUEST['actionType']){
			//var_dump($_REQUEST);
			$statusId = $_REQUEST['sort_order_update'];
			$sortValue = $_REQUEST['sort_order_update'.$statusId];	
			
			if($_REQUEST['actionType'] == 'Up'){
				if($sortValue !='1' && $sortValue != ''){

					//var_dump('mufiz');

					$minusValue = intval($sortValue)-1;
					$projectUpdate= ProjectType::find()->where(['sort_order' => $sortValue])->one();
					$projectUpdate1= ProjectType::find()->where(['sort_order' => $minusValue])->one();
					$projectUpdate->sort_order=$minusValue;
					$projectUpdate->update();
					
					$projectUpdate1->sort_order=$sortValue;
					$projectUpdate1->update();
				}
			}else if($_REQUEST['actionType'] == 'Down'){
				//var_dump('mufiz');
				if($max_sort_order !=$sortValue && $sortValue != ''){
					
					$plusValue = intval($sortValue)+1;
					$projectUpdate= ProjectType::find()->where(['sort_order' => $sortValue])->one();
					$projectUpdate1= ProjectType::find()->where(['sort_order' => $plusValue])->one();
					$projectUpdate->sort_order=$plusValue;
					$projectUpdate->update();
					$projectUpdate1->sort_order=$sortValue;
					$projectUpdate1->update();
				}
			}
		}

        $searchModel = new ProjectTypeSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Displays a single ProjectType model.
     * @param string $id
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
     * Creates a new ProjectType model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ProjectType;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ProjectType model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
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
     * Deletes an existing ProjectType model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ProjectType model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return ProjectType the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ProjectType::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
