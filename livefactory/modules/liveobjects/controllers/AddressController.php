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
namespace livefactory\modules\liveobjects\controllers;

use Yii;
use livefactory\models\Address;
use livefactory\models\search\Address as AddressSearch;
use yii\web\Controller;
use livefactory\models\State;
use livefactory\models\City;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use livefactory\models\search\CommonModel as SessionVerification;
/**
 * AddressController implements the CRUD actions for Address model.
 */
class AddressController extends Controller
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
		//error_reporting(0);
		SessionVerification::checkSessionDestroy();
    	if(!isset(Yii::$app->user->identity->id)){
          $this->redirect(array('/site/login'));
		}
		if(Yii::$app->user->identity->user_role_id !='1'){
          $this->redirect(array('/site/index'));
		}
	}
    /**
     * Lists all Address models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AddressSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Displays a single Address model.
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
     * Creates a new Address model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Address;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Address model.
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
	public function actionAjaxLoadStates(){
		$country_id=!empty($_REQUEST['country_id'])?$_REQUEST['country_id']:'';
		$state_id=!empty($_REQUEST['state_id'])?$_REQUEST['state_id']:'';
		$states = State::find()->orderBy('state')->where("country_id=$country_id")->asArray()->all();
		 return $this->renderPartial('ajax-load-states', [
                'states' => $states,
				'state_id'=>$state_id,
            ]);
	}
	public function actionAjaxLoadCities(){
		$state_id=!empty($_REQUEST['state_id'])?$_REQUEST['state_id']:'';
		$city_id=!empty($_REQUEST['city_id'])?$_REQUEST['city_id']:'';
		$cities=City::find()->orderBy('city')->where("state_id=$state_id")->asArray()->all();
		 return $this->renderPartial('ajax-load-cities', [
                'cities' => $cities,
				'city_id'=>$city_id,
            ]);
	}
    /**
     * Deletes an existing Address model.
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
     * Finds the Address model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Address the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Address::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
