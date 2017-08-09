<?php

namespace livefactory\models;

use Yii;

/**
 * This is the model class for table "lot_file".
 *
 * @property string $id
 * @property integer $entity_id
 * @property string $entity_type
 * @property string $file_name
 * @property string $file_title
 * @property string $file_type
 * @property string $file_path
 * @property integer $added_at
 * @property integer $updated_at
 * @property integer $uploaded_user_id
 */
class File extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'lot_file';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['entity_id', 'entity_type', 'file_name', 'file_title', 'file_type', 'file_path', 'added_at', 'uploaded_user_id'], 'required'],
            [['entity_id', 'added_at', 'updated_at', 'uploaded_user_id'], 'integer'],
            [['entity_type', 'file_name', 'file_type', 'file_path'], 'string', 'max' => 255],
            [['file_title'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'entity_id' => Yii::t('app', 'Entity ID'),
            'entity_type' => Yii::t('app', 'Entity Type'),
            'file_name' => Yii::t('app', 'File Name'),
            'file_title' => Yii::t('app', 'File Title'),
            'file_type' => Yii::t('app', 'File Type'),
            'file_path' => Yii::t('app', 'File Path'),
            'added_at' => Yii::t('app', 'Added At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'uploaded_user_id' => Yii::t('app', 'Uploaded User ID'),
        ];
    }
	public function getUser()
    {
    	return $this->hasOne(User::className(), ['id' => 'uploaded_user_id']);
    }
}
