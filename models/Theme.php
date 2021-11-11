<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "theme".
 *
 * @property int $id
 * @property string $name
 * @property string $text
 * @property int $status
 * @property string $date
 * @property int $id_user
 *
 * @property Answer[] $answers
 * @property User $user
 */
class Theme extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'theme';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'text'], 'required'],
            [['text'], 'string'],
            [['name'], 'string', 'max' => 255],
            [['id_user'], 'default', 'value'=>Yii::$app->user->getId()],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Заголовок',
            'text' => 'Текст',
            'status' => 'Статус',
            'date' => 'Дата добавления',
            'id_user' => 'ID пользователя',
        ];
    }

    /**
     * Gets query for [[Answers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAnswers()
    {
        return $this->hasMany(Answer::className(), ['id_theme' => 'id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'id_user']);
    }

    public function getStatusText()
    {
        switch ($this->status) {
            case 0:
                return 'Отклонена';
                break;
            case 1:
                return 'Ожидание модерации';
                break;
            case 2:
                return 'Одобрена';
                break;
        }
    }

    public function approve()
    {
        $this->status = 2;
        $this->save();
    }

    public function reject()
    {
        $this->status = 0;
        $this->save();
    }
}
