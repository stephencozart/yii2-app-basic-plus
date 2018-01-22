<?php

namespace app\models;

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
 * @property string $nickname
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{
    public $new_password;

    public function fields()
    {
        return [
            'id',
            'first_name',
            'last_name',
            'email',
            'avatar',
            'status_id',
            'created_on',
            'updated_on'
        ];
    }

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
            [['email'], 'unique', 'targetAttribute' => ['email'], 'message' => 'That email address has already been used.'],
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

    /**
     * @param bool $insert
     * @return bool
     */
    function beforeSave($insert)
    {
        if ($insert === true && $this->password != null) {
            $this->password = Yii::$app->security->generatePasswordHash($this->password);
        } else if (count($this->new_password) > 0 && !empty($this->new_password)) {
            $this->password = Yii::$app->security->generatePasswordHash($this->new_password);
        }

        $this->updated_on = date('Y-m-d H:i:s');

        return parent::beforeSave($insert);
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
        return self::find()->where(['auth_key' => $token])->one();
    }

    /**
     * @param $email
     * @return array|null|\yii\db\ActiveRecord
     */
    public static function findByEmail($email)
    {
        return self::find()->where(['email' => $email])->one();
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
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    /**
     * @return bool
     */
    public function isActivated()
    {
        return ($this->auth_key === null);
    }

    public function getAvatar($s=50, $d='mm')
    {
        $url = 'https://www.gravatar.com/avatar/';
        $url .= md5( strtolower( trim( $this->email ) ) );
        $url .= "?s=$s&d=$d";

        return $url;
    }


}
