<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "answer".
 *
 * @property int $id
 * @property string $date
 * @property string $text
 * @property int $id_user
 * @property int $id_theme
 *
 * @property Theme $theme
 * @property User $user
 */
class Answer extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'answer';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['text', 'id_theme'], 'required'],
            [['text'], 'string'],
            [['id_theme'], 'integer'],
            [['id_user'], 'default', 'value' => Yii::$app->user->getId()],
            [['id_theme'], 'exist', 'skipOnError' => true,
                'targetClass' => Theme::className(), 'targetAttribute' => ['id_theme' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date' => 'Дата',
            'text' => 'Текст',
            'id_user' => 'ID пользователя',
            'id_theme' => 'ID темы',
        ];
    }

    /**
     * Gets query for [[Theme]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTheme()
    {
        return $this->hasOne(Theme::className(), ['id' => 'id_theme']);
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
}
