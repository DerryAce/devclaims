<?php

namespace livefactory\models;

use Yii;

/**
 * This is the model class for table "lot_email_template".
 *
 * @property integer $id
 * @property string $template_name
 * @property string $template_subject
 * @property string $template_body
 * @property integer $added_at
 * @property integer $updated_at
 */
class EmailTemplate extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'lot_email_template';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['template_name', 'template_subject', 'template_body'], 'required'],
            [['template_subject', 'template_body'], 'string'],
            [['added_at', 'updated_at'], 'integer'],
            [['template_name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'template_name' => Yii::t('app', 'Template Name'),
            'template_subject' => Yii::t('app', 'Template Subject'),
            'template_body' => Yii::t('app', 'Template Body'),
            'added_at' => Yii::t('app', 'Added At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
}
