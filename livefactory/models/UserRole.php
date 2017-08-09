<?php



namespace livefactory\models;



use Yii;



/**

 * This is the model class for table "lot_user_role".

 *

 * @property integer $id

 * @property string $role

 * @property string $label

 * @property integer $status

 * @property integer $created_at

 * @property integer $updated_at

 */

class UserRole extends \yii\db\ActiveRecord

{

    /**

     * @inheritdoc

     */

    public static function tableName()

    {

        return 'lot_user_role';

    }



    /**

     * @inheritdoc

     */

    public function rules()

    {

        return [

            [['role', 'label', 'status'], 'required'],

            [['status'], 'integer'],

            [['role', 'label', 'created_at', 'updated_at'], 'string', 'max' => 255]

        ];

    }



    /**

     * @inheritdoc

     */

    public function attributeLabels()

    {

        return [

            'id' => Yii::t('app', 'ID'),

            'role' => Yii::t('app', 'Role'),

            'label' => Yii::t('app', 'Label'),

            'status' => Yii::t('app', 'Status'),

            'created_at' => Yii::t('app', 'Created At'),

            'updated_at' => Yii::t('app', 'Updated At'),

        ];

    }

}

