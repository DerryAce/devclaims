<?php



namespace livefactory\models;



use Yii;



/**

 * This is the model class for table "lot_contact".

 *

 * @property integer $id

 * @property string $first_name

 * @property string $middle_name

 * @property string $last_name

 * @property string $email

 * @property string $phone

 * @property integer $mobile

 * @property integer $fax

 * @property string $entity_type

 * @property integer $entity_id

 * @property integer $created_at

 * @property integer $updated_at

 */

class Contact extends \yii\db\ActiveRecord

{

    /**

     * @inheritdoc

     */

    public static function tableName()

    {

        return 'lot_contact';

    }



    /**

     * @inheritdoc

     */

    public function rules()

    {

        return [

            [['first_name','last_name', 'mobile', 'entity_type'], 'required'],

            [['mobile', 'entity_id', 'created_at', 'updated_at'], 'integer'],

            [['first_name', 'last_name', 'email','fax', 'phone', 'entity_type'], 'string', 'max' => 255],

            [['middle_name'], 'string', 'max' => 32]

        ];

    }



    /**

     * @inheritdoc

     */

    public function attributeLabels()

    {

        return [

            'id' => Yii::t('app', 'ID'),

            'first_name' => Yii::t('app', 'First Name'),

            'middle_name' => Yii::t('app', 'Middle Name'),

            'last_name' => Yii::t('app', 'Last Name'),

            'email' => Yii::t('app', 'Email'),

            'phone' => Yii::t('app', 'Phone'),

            'mobile' => Yii::t('app', 'Mobile'),

            'fax' => Yii::t('app', 'Fax'),

            'entity_type' => Yii::t('app', 'Entity Type'),

            'entity_id' => Yii::t('app', 'Entity ID'),

            'created_at' => Yii::t('app', 'Created At'),

            'updated_at' => Yii::t('app', 'Updated At'),

        ];

    }

}

