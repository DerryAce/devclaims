<?php

namespace livefactory\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "lot_user".
 *
 * @property integer $id
 * @property string $first_name
 * @property string $last_name
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property integer $user_type_id
 * @property integer $user_role_id
 * @property integer $role
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class User extends ActiveRecord implements IdentityInterface
{
	
	const STATUS_DELETED = 0;
	const STATUS_ACTIVE = 10;
	const ROLE_USER = 10;
	
	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return 'lot_user';
	}
	
	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [ 
				[ 
						[ 
								'first_name',
								'last_name',
								'username',
								'email',
								'user_type_id',
								'user_role_id' 
						],
						'required' 
				],
				[ 
						[ 
								'user_type_id',
								'user_role_id',
								'role',
								'status',
								'created_at',
								'updated_at' 
						],
						'integer' 
				],
				[ 
						[ 
								'first_name',
								'last_name',
								'username',
								'password_hash',
								'password_reset_token',
								'email',
								'about' 
						],
						'string',
						'max' => 255 
				],
				[ 
						[ 
								'auth_key' 
						],
						'string',
						'max' => 32 
				],
				[ 
						[ 
								'email' 
						],
						'email' 
				],
				[ 
						[ 
								'email','username' 
						],
						'unique' 
				] 
		]
		;
	}
	
	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [ 
				'id' => Yii::t ( 'app', 'ID' ),
				'first_name' => Yii::t ( 'app', 'First Name' ),
				'last_name' => Yii::t ( 'app', 'Last Name' ),
				'username' => Yii::t ( 'app', 'Username' ),
				'auth_key' => Yii::t ( 'app', 'Auth Key' ),
				'password_hash' => Yii::t ( 'app', 'Password' ),
				'password_reset_token' => Yii::t ( 'app', 'Password Reset Token' ),
				'email' => Yii::t ( 'app', 'Email' ),
				'user_type_id' => Yii::t ( 'app', 'User Type' ),
				'user_role_id' => Yii::t ( 'app', 'User Role' ),
				'role' => Yii::t ( 'app', 'Role' ),
				'status' => Yii::t ( 'app', 'Status' ),
				'created_at' => Yii::t ( 'app', 'Created At' ),
				'updated_at' => Yii::t ( 'app', 'Updated At' ) 
		];
	}
	/**
	 * @inheritdoc
	 */
	public static function findIdentity($id)
	{
		return static::findOne ( [ 
				'id' => $id,
				'status' => self::STATUS_ACTIVE 
		] );
	}
	
	/**
	 * @inheritdoc
	 */
	public static function findIdentityByAccessToken($token, $type = null)
	{
		throw new NotSupportedException ( '"findIdentityByAccessToken" is not implemented.' );
	}
	
	/**
	 * Finds user by username
	 *
	 * @param string $username        	
	 * @return static|null
	 */
	public static function findByUsername($username)
	{
		return static::findOne ( [ 
				'username' => $username,
				'status' => self::STATUS_ACTIVE 
		] );
	}
	
	public static function findByEmail($email)
	{
		return static::findOne ( [ 
				'email' => $email,
				'status' => self::STATUS_ACTIVE 
		] );
	}
	public static function findByEmailOrUsername($username)
	{
		return static::find()->where("(email='$username' or username='$username') and status=".self::STATUS_ACTIVE)->one(); 
	}
	
	/**
	 * Finds user by password reset token
	 *
	 * @param string $token
	 *        	password reset token
	 * @return static|null
	 */
	public static function findByPasswordResetToken($token)
	{
		if (! static::isPasswordResetTokenValid ( $token ))
		{
			return null;
		}
		
		return static::findOne ( [ 
				'password_reset_token' => $token,
				'status' => self::STATUS_ACTIVE 
		] );
	}
	
	/**
	 * Finds out if password reset token is valid
	 *
	 * @param string $token
	 *        	password reset token
	 * @return boolean
	 */
	public static function isPasswordResetTokenValid($token)
	{
		if (empty ( $token ))
		{
			return false;
		}
		$expire = Yii::$app->params ['user.passwordResetTokenExpire'];
		$parts = explode ( '_', $token );
		$timestamp = ( int ) end ( $parts );
		return $timestamp + $expire >= time ();
	}
	
	/**
	 * @inheritdoc
	 */
	public function getId()
	{
		return $this->getPrimaryKey ();
	}
	
	/**
	 * @inheritdoc
	 */
	public function getAuthKey()
	{
		return $this->auth_key;
	}
	
	/**
	 * @inheritdoc
	 */
	public function validateAuthKey($authKey)
	{
		return $this->getAuthKey () === $authKey;
	}
	
	/**
	 * Validates password
	 *
	 * @param string $password
	 *        	password to validate
	 * @return boolean if password provided is valid for current user
	 */
	public function validatePassword($password)
	{
		return Yii::$app->security->validatePassword ( $password, $this->password_hash );
	}
	
	/**
	 * Generates password hash from password and sets it to the model
	 *
	 * @param string $password        	
	 */
	public function setPassword($password)
	{
		$this->password_hash = Yii::$app->security->generatePasswordHash ( $password );
	}
	
	
	public function beforeSave($insert)
	{
		 /*
		if (! isset ( $this->password_hash ) && $this->id != '')
		{
			// genearte a random password for user
			$length = 8;
			$new_password = Yii::$app->security->generateRandomString ( $length );
			$new_password = "admin123!";
		}
		$this->setPassword ( $new_password );
		*/
		
		return parent::beforeSave ( $insert );
	}
	
	
	/**
	 * Generates "remember me" authentication key
	 */
	public function generateAuthKey()
	{
		$this->auth_key = Yii::$app->security->generateRandomString ();
	}
	
	/**
	 * Generates new password reset token
	 */
	public function generatePasswordResetToken()
	{
		$this->password_reset_token = Yii::$app->security->generateRandomString () . '_' . time ();
	}
	
	/**
	 * Removes password reset token
	 */
	public function removePasswordResetToken()
	{
		$this->password_reset_token = null;
	}
	
	public function getUserRole()
	{
		return $this->hasOne(UserRole::className(), ['id' => 'user_role_id']);
	}
	
	public function getUserType()
	{
		return $this->hasOne(UserType::className(), ['id' => 'user_type_id']);
	}
}
