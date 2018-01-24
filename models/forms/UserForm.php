<?php namespace app\models\forms;

use app\models\User;
use yii\base\Model;

/**
 * Class UserForm
 * @package app\models\forms
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $password
 * @property string $password_confirmation
 * @property string $activation_code
 * @property User $user
 */
class UserForm extends Model {
    const SCENARIO_REGISTER = 'register';
    const SCENARIO_LOGIN = 'login';
    const SCENARIO_UPDATE = 'update';
    const SCENARIO_ACTIVATE = 'activate';

    public $first_name;
    public $last_name;
    public $email;
    public $password;
    public $password_confirmation;
    public $remember_me;
    private $user;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['first_name', 'last_name', 'email', 'password', 'password_confirmation', 'remember_me'], 'safe'],
            [['email'], 'required'],
            [['email'], 'email'],
            ['password_confirmation', 'compare', 'compareAttribute' => 'password', 'message' => 'The password and password confirmation must be the same.'],
            ['email', 'unique', 'targetClass' => 'app\models\User', 'message' => 'This email address has already been taken.', 'on' => static::SCENARIO_REGISTER],
            ['password', 'validatePassword', 'on' => static::SCENARIO_LOGIN],
            ['remember_me', 'boolean', 'on' => static::SCENARIO_LOGIN],
        ];
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        return [
            static::SCENARIO_REGISTER => ['email', 'password', 'password_confirmation', 'first_name', 'last_name'],
            static::SCENARIO_LOGIN => ['email', 'password'],
            static::SCENARIO_ACTIVATE => ['password','password_confirmation','email','verifyActivationCode']
        ];
    }

    public function verifyActivationCode()
    {
        $user = User::find()->where(['email'=>$this->email, 'activation_code' => $this->activation_code])->one();

        if ($user === null) {

            $this->addError('password', 'Invalid activation code.');

        }
    }

    /**
     * @return User|null
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user)
    {
        $this->user = $user;
    }

    /**
     * @return bool
     */
    public function register()
    {
        $this->user = new User();
        $this->user->attributes = $this->attributes;

        // generate a random string to be used in email validation
        $this->user->auth_key = \Yii::$app->security->generateRandomString(64);

        return ($this->validate() && $this->user->save());
    }

    /**
     * @return bool
     */
    public function login()
    {
        $this->user = User::findByEmail($this->email);

        if ($this->validate() && $this->user !== null) {
            if (!$this->user->isActivated()) {
                $this->addError('email', 'The user account is not activated');
            } else {
                return \Yii::$app->user->login($this->getUser(), $this->remember_me ? 3600*24*30 : 0);
            }
        }
        return false;
    }

    public function activate()
    {
        if ($this->validate()) {
            return User::updateAll(['activation_code' => null,
                ['password'=>\Yii::$app->security->generatePasswordHash($this->password)]],
                ['activation_code' => $this->activation_code, 'email' => $this->email]
            );
        }

        return false;
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect email or password.');
            }
        }
    }
}