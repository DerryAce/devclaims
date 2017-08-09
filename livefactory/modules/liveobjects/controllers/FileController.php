<?php

namespace liveobjects\modules\setting\controllers;

use Yii;
use liveobjects\models\File;
use liveobjects\models\search\File as FileSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use livefactory\models\search\CommonModel as SessionVerification;
/**
 * FileController implements the CRUD actions for File model.
 */
class FileController extends Controller {
	
	//public $modelClass = 'common\models\File';
	public function init(){
		error_reporting(0);
		SessionVerification::checkSessionDestroy();
    	if(!isset(Yii::$app->user->identity->id)){
          $this->redirect(array('/site/login'));
		}
	}
	public function behaviors() {
		return [ 
				'verbs' => [ 
						'class' => VerbFilter::className (),
						'actions' => [ 
								'delete' => [ 
										'post' 
								] 
						] 
				] 
		];
	}
	
	/**
	 * Lists all File models.
	 *
	 * @return mixed
	 */
	public function actionIndex() {
		$searchModel = new FileSearch ();
		$dataProvider = $searchModel->search ( Yii::$app->request->getQueryParams () );
		
		return $this->render ( 'index', [ 
				'dataProvider' => $dataProvider,
				'searchModel' => $searchModel 
		] );
	}
	
	/**
	 * Displays a single File model.
	 *
	 * @param string $id        	
	 * @return mixed
	 */
	public function actionView($id) {
		$model = $this->findModel ( $id );
		
		if ($model->load ( Yii::$app->request->post () ) && $model->save ()) {
			return $this->redirect ( [ 
					'view',
					'id' => $model->id 
			] );
		} else {
			return $this->render ( 'view', [ 
					'model' => $model 
			] );
		}
	}
	
	/**
	 * Creates a new File model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 *
	 * @return mixed
	 */
	public function actionCreate() {
		$model = new File ();
		
		if ($model->load ( Yii::$app->request->post () ) && $model->save ()) {
			
			uploadFile ();
			
			return $this->redirect ( [ 
					'view',
					'id' => $model->id 
			] );
		} else {
			return $this->render ( 'create', [ 
					'model' => $model 
			] );
		}
	}
	
	protected function cleanFileName($string)
	{
		// Remove special accented characters - ie. s�.
		$clean_name = strtr($string, array('�' => 'S','�' => 'Z','�' => 's','�' => 'z','�' => 'Y','�' => 'A','�' => 'A','�' => 'A','�' => 'A','�' => 'A','�' => 'A','�' => 'C','�' => 'E','�' => 'E','�' => 'E','�' => 'E','�' => 'I','�' => 'I','�' => 'I','�' => 'I','�' => 'N','�' => 'O','�' => 'O','�' => 'O','�' => 'O','�' => 'O','�' => 'O','�' => 'U','�' => 'U','�' => 'U','�' => 'U','�' => 'Y','�' => 'a','�' => 'a','�' => 'a','�' => 'a','�' => 'a','�' => 'a','�' => 'c','�' => 'e','�' => 'e','�' => 'e','�' => 'e','�' => 'i','�' => 'i','�' => 'i','�' => 'i','�' => 'n','�' => 'o','�' => 'o','�' => 'o','�' => 'o','�' => 'o','�' => 'o','�' => 'u','�' => 'u','�' => 'u','�' => 'u','�' => 'y','�' => 'y'));
		$clean_name = strtr($clean_name, array('�' => 'TH', '�' => 'th', '�' => 'DH', '�' => 'dh', '�' => 'ss', '�' => 'OE', '�' => 'oe', '�' => 'AE', '�' => 'ae', '�' => 'u'));
		
		$clean_name = preg_replace(array('/\s/', '/\.[\.]+/', '/[^\w_\.\-]/'), array('_', '.', ''), $clean_name);
		$clean_name = strtolower($clean_name);
		return $clean_name;
	} 
	protected function uploadFile($id) {
		$model = new File ();
		$model = $this->findModel ( $id );
		
		$directory = 'files/';
		
		$file = $_FILES ['file'] ['tmp_name'];
		
		$file_type = $_FILES ['file'] ['type'];
		$file_size = $_FILES ['file'] ['size'];
		
		$file_name = $this->cleanFileName(pathinfo ( $_FILES ['file'] ['name'], PATHINFO_FILENAME ) . "_" . $model->id . "." . pathinfo ( $_FILES ['file'] ['name'], PATHINFO_EXTENSION ));
		$file_path = $directory . $file_name;
		
		$model->file_name = $file_name;
		$model->file_path = $file_path;
		$model->file_type = $file_type;
		$model->file_size = $file_size;
		
		$model->save ();
		move_uploaded_file ( $file, $file_path );
	}
	public function actionCreateimage() {
		$model = new File ();
		
		if ($model->load ( Yii::$app->request->post () ) && $model->save ()) {
			
			$this->uploadFile ($model->id);
			
			return $this->redirect ( [ 
					'view',
					'id' => $model->id 
			] );
		} else {
			return $this->render ( 'createimage', [ 
					'model' => $model 
			] );
		}
	}
	public function actionCreatevideo() {
		$model = new File ();
		
		if ($model->load ( Yii::$app->request->post () ) && $model->save ()) {
			
			$this->uploadFile ($model->id);
			
			return $this->redirect ( [ 
					'view',
					'id' => $model->id 
			] );
		} else {
			return $this->render ( 'createvideo', [ 
					'model' => $model 
			] );
		}
	}
	public function actionCreateaudio() {
		$model = new File ();
		
		if ($model->load ( Yii::$app->request->post () ) && $model->save ()) {
			
			$this->uploadFile ($model->id);
			
			return $this->redirect ( [ 
					'view',
					'id' => $model->id 
			] );
		} else {
			return $this->render ( 'createaudio', [ 
					'model' => $model 
			] );
		}
	}
	public function actionCreatefile() {
		$model = new File ();
		
		if ($model->load ( Yii::$app->request->post () ) && $model->save ()) {
			
			$this->uploadFile ($model->id);
			
			return $this->redirect ( [ 
					'view',
					'id' => $model->id 
			] );
		} else {
			return $this->render ( 'createfile', [ 
					'model' => $model 
			] );
		}
	}
	
	/**
	 * Updates an existing File model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 *
	 * @param string $id        	
	 * @return mixed
	 */
	public function actionUpdate($id) {
		$model = $this->findModel ( $id );
		
		if ($model->load ( Yii::$app->request->post () ) && $model->save ()) {
			
			$this->uploadFile ($model->id);
			
			return $this->redirect ( [ 
					'view',
					'id' => $model->id 
			] );
		} else {
			return $this->render ( 'update', [ 
					'model' => $model 
			] );
		}
	}
	
	/**
	 * Deletes an existing File model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 *
	 * @param string $id        	
	 * @return mixed
	 */
	public function actionDelete($id) {
		$this->findModel ( $id )->delete ();
		
		return $this->redirect ( [ 
				'index' 
		] );
	}
	
	/**
	 * Finds the File model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 *
	 * @param string $id        	
	 * @return File the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id) {
		if (($model = File::findOne ( $id )) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException ( 'The requested page does not exist.' );
		}
	}
}
