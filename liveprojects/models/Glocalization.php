<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "lot_glocalization".
 *
 * @property integer $id
 * @property string $language
 * @property string $locale
 */
class Glocalization extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'lot_glocalization';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'language', 'locale'], 'required'],
            [['id'], 'integer'],
            [['language'], 'string', 'max' => 100],
            [['locale'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'language' => Yii::t('app', 'Language'),
            'locale' => Yii::t('app', 'Locale'),
        ];
    }
}
