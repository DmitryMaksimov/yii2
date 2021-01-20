<?php
namespace backend\models;

use Yii;
use yii\base\Model;
use common\models\User;

/**
 * User form
 */
class UserForm extends Model
{
    public $id;
    public $username;
    public $email;
    public $password;

    public function __construct($user_id) {
        parent::__construct();

        $user = User::findOne($user_id);

        if($user) {
            $this->id = $user->id;
            $this->username = $user->username;
            $this->email = $user->email;
        } else {
            $this->id = null;
            $this->username = '';
            $this->email = '';
        }
        $this->password = '';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['id', 'integer'],
            
            ['username', 'unique',
                'targetAttribute' => 'username',
                'targetClass' => '\common\models\User',
                'when' => function ($model, $attribute) {
                    return $model->{$attribute} != User::findOne($model->id)->{$attribute};
                },
                'message' => 'This username can not be taken.'
            ],

            ['email', 'unique',
                'targetAttribute' => 'email',
                'targetClass' => '\common\models\User',
                'when' => function ($model, $attribute) {
                    return $model->{$attribute} != User::findOne($model->id)->{$attribute};
                },
                'message' => 'This e-mail can not be taken.'
            ],

            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],

            ['password', 'string', 'min' => Yii::$app->params['user.passwordMinLength']],
        ];
    }

    /**
     * Signs user up.
     *
     * @return bool whether the creating new account was successful and email was sent
     */
    public function save()
    {
        if (!$this->validate()) {
            return false;
        }
        
        if($this->id != null)
            $user = User::findOne($this->id);
        else {
            $user = new User;
            $user->setPassword('');
            $user->generateAuthKey();
            $user->status = User::STATUS_ACTIVE;
        }

        $user->username = $this->username;
        $user->email = $this->email;

        if($this->password)
            $user->setPassword($this->password);

        if( $user->save() ) {
            if($this->id == null) {
                $auth = Yii::$app->authManager;
                $authorRole = $auth->getRole('author');
                $auth->assign($authorRole, $user->getId());
            }
            return true;
        }
        return false;
    }

}
