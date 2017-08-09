<?php



namespace livefactory\models;



use Yii;



/**

 * This is the model class for table "lot_user_type".

 *

 * @property integer $id

 * @property string $type

 * @property string $label

 * @property integer $status

 * @property integer $created_at

 * @property integer $updated_at

 */

class UserType extends \yii\db\ActiveRecord

{

    /**

     * @inheritdoc

     */

    public static function tableName()

    {

        return 'lot_user_type';

    }



    /**

     * @inheritdoc

     */

    public function rules()

    {

        return [

            [['type', 'label', 'status'], 'required'],

            [['status'], 'integer'],

            [['type', 'label', 'created_at', 'updated_at'], 'string', 'max' => 255]

        ];

    }



    /**

     * @inheritdoc

     */

    public function attributeLabels()

    {

        return [

            'id' => Yii::t('app', 'ID'),

            'type' => Yii::t('app', 'Type'),

            'label' => Yii::t('app', 'Label'),

            'status' => Yii::t('app', 'Status'),

            'created_at' => Yii::t('app', 'Created At'),

            'updated_at' => Yii::t('app', 'Updated At'),

        ];

    }

}

