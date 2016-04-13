<?php

namespace app\models;

use yii\db\ActiveQuery;
use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $password
 * @property string $activation_code
 * @property string $auth_key
 * @property string $reset_code
 * @property integer $status_id
 * @property string $created_on
 * @property string $updated_on
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status_id'], 'integer'],
            [['created_on', 'updated_on'], 'safe'],
            [['first_name', 'last_name', 'email', 'auth_key'], 'string', 'max' => 255],
            [['password', 'activation_code', 'reset_code'], 'string', 'max' => 64],
            [['email'], 'unique', 'targetAttribute' => ['email'], 'message' => 'That email address has already been used.']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'email' => 'Email',
            'password' => 'Password',
            'activation_code' => 'Activation Code',
            'reset_code' => 'Reset Code',
            'status_id' => 'Status',
            'created_on' => 'Created On',
            'updated_on' => 'Updated On',
        ];
    }

    public static function find()
    {
        return new ActiveQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        $User = self::findOne($id);
        return $User ? $User : null;
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return self::find()->where(['auth_key'=>$token])->one();
    }

    /**
     * Finds user by username
     *
     * @param  string      $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return self::find()->where(['email'=>$username])->one();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
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
        return $this->auth_key === $authKey;
    }

    /**
     * Validates password
     *
     * @param  string  $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === $password;
    }

}
