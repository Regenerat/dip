<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string|null $login
 * @property string|null $password
 * @property string|null $email
 * @property string|null $phone
 * @property string|null $fio
 * @property int|null $role_id
 *
 * @property Report[] $reports
 * @property Role $role
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    public function rules()
    {
        return [
            [['role_id'], 'integer'],
            [['login', 'password', 'email', 'phone', 'fio'], 'string', 'max' => 255],
            [['role_id'], 'exist', 'skipOnError' => true, 'targetClass' => Role::class, 'targetAttribute' => ['role_id' => 'id']],
            [['email'], 'email', 'message' => 'неправильно, попробуй еще разок'],
            [['phone'], 'match', 'pattern' => '/^\d{11}/', 'message' => 'неправильно, попробуй еще разок']
        ];
    }

    public function attributeLabels()
    {
        return [
            //'id' => 'ID',
            'login' => 'Login',
            //'password' => 'Password',
            'email' => 'Email',
            'phone' => 'Phone',
            'fio' => 'Fio',
            'role_id' => 'Role ID',
        ];
    }

    public function getReports()
    {
        return $this->hasMany(Report::class, ['user_id' => 'id']);
    }

    public function getRole()
    {
        return $this->hasOne(Role::class, ['id' => 'role_id']);
    }

    public static function login($login, $pass) {
        $user = self::find()->where(['login'=> $login])->one();
        if($user && $user->validatePassword($pass)) {
            return $user;
        }
        return null;
    }

    public static function findIdentity($id)
    {
        return static::find()->where(['id'=> $id])->one();
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return null;
    }

    public function validateAuthKey($authKey)
    {
        return null;
    }

    public function validatePassword($password)
    {
        return Yii::$app->getSecurity()->validatePassword($password, $this->password);
    }

    public function getUsername() {
        return $this->login;
    }

    public function setPassword($password) {
        $this->password = Yii::$app->security->generatePasswordHash($password);
    }

    public static function findByLogin($login) {
        return static::find()->where(['login'=> $login])->one();
    }
}
