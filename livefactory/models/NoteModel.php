<?php

namespace livefactory\models;
use livefactory\models\Note;
use Yii;
use yii\filters\VerbFilter;
use yii\db\Query;
class NoteModel extends \yii\db\ActiveRecord
{
	/**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '';
    }
    public static  function noteInsert($entity_id, $entity_type) {
		$addNotes= new Note();
		$addNotes->entity_id=$entity_id;
		$addNotes->entity_type=$entity_type;
		$addNotes->notes=$_REQUEST['notes'];
		$addNotes->user_id=Yii::$app->user->identity->id;
		$addNotes->added_at=strtotime(date('Y-m-d'));
		$addNotes->save();
		$nid=$addNotes->id;
		return $nid;
	}
	public static  function noteEdit(){
		$editNote= Note::find()->where(['id' =>$_REQUEST['note_id']])->one();
		$editNote->notes=$_REQUEST['notes'];
		$editNote->updated_at=strtotime(date('Y-m-d'));
		$editNote->update();
	}
}
