<?php namespace app\models\forms;

use yii\base\Model;
use app\models\User;

/**
 * Class PasswordResetForm
 * @package app\models\forms
 * @property User $user
 * @property string $password;
 * @property string $password_confirmation;
 */
class PasswordResetForm extends Model {
    // Can either be used to request a password reset or do the actual resetting
    const SCENARIO_REQUEST = 'request';
    const SCENARIO_RESET = 'reset';

    private $user;
    public $email;
    public $password;
    public $password_confirmation;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['password', 'password_confirmation', 'email'], 'required'],
            [['email'], 'email'],
            ['password_confirmation', 'compare', 'compareAttribute' => 'password', 'message' => 'The password and password confirmation must be the same.'],
        ];
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        return [
            static::SCENARIO_REQUEST => ['email'],
            static::SCENARIO_RESET => ['password', 'password_confirmation']
        ];
    }

    /**
     * @return bool
     */
    public function request()
    {
        $this->user = User::findByEmail($this->email);

        if ($this->user !== null) {
            if ($this->validate()) {
                $this->user->reset_code = \Yii::$app->security->generateRandomString(64);
                return $this->user->save();
            }
        } else {
            $this->addError('email', 'An account with this email does not exist.');
        }

        return false;
    }

    /**
     * @return bool
     */
    public function reset()
    {
        if ($this->user !== null && $this->validate()) {
            $this->user->new_password = $this->password;
            $this->user->reset_code = null;
            return $this->user->save();
        }
        return false;
    }

    /**
     * @param $user
     */
    public function setUser(User $user)
    {
        $this->user = $user;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }
}