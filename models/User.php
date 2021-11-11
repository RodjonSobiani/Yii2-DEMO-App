<?php

namespace app\models;

use phpDocumentor\Reflection\Types\This;
use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $email
 * @property string $name
 * @property string $surname
 * @property string $password
 * @property int $active
 * @property int $role
 *
 * @property Answer $answer
 * @property Answer[] $answers
 */
class User extends ActiveRecord implements IdentityInterface
{
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
//        return $this->authKey;
        return null;
    }

    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['email', 'name', 'surname', 'password'], 'required'],
            [['email', 'name', 'surname', 'password'], 'string', 'max' => 255],
            [['email'], 'unique'],
            ['email', 'email'],
        ];
    }

    public function beforeSave($insert)
    {
//        if ($this->isNewRecord) {
            $this->password = md5($this->password);
//        }
        return parent::beforeSave($insert);
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'full_name' => 'ФИО',
            'username' => 'Логин',
            'email' => 'Электронная почта',
            'name' => 'Имя',
            'surname' => 'Фамилия',
            'password' => 'Пароль',
            'role' => 'Роль',
            'active' => 'Активность'
        ];
    }

    /**
     * Gets query for [[Answer]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAnswer()
    {
        return $this->hasOne(Answer::className(), ['id' => 'id']);
    }

    /**
     * Gets query for [[Answers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAnswers()
    {
        return $this->hasMany(Answer::className(), ['id_user' => 'id']);
    }

    public static function findByUsername($email)
    {
        return User::findOne(['email' => $email]);
    }

    public function validatePassword($password)
    {
        return $this->password === md5($password);
    }

    public function isAdmin()
    {
        return $this->role == 1;
    }

    public function isActive()
    {
        return $this->active == 1;
    }

    public function getActiveUser()
    {
        switch ($this->active) {
            case 0: return 'Деативирован';
            case 1: return 'Активирован';
        }
    }

    public function activate()
    {
        $this->active = 1;
        $this->save();
    }

    public function deactivate()
    {
        $this->active = 0;
        $this->save();
    }

    public function getRoleUser()
    {
        switch ($this->role) {
            case 0: return 'Пользователь';
            case 1: return 'Администратор';
        }
    }

    public function makeAdmin()
    {
        $this->role = 1;
        $this->save();
    }

    public function makeUser()
    {
        $this->role = 0;
        $this->save();
    }
}
