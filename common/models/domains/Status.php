<?php

namespace common\models\domains;

use Yii;

/**
 * This is the model class for table "status".
 *
 * @property int $id
 * @property int $status_name
 * @property int $sending_messages
 * @property int $publication_info
 * @property int $view_info
 *
 * @property User[] $users
 */
class Status extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'status';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status_name'], 'required'],
            [['status_name', 'sending_messages', 'publication_info', 'view_info'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'status_name' => 'Status Name',
            'sending_messages' => 'Sending Messages',
            'publication_info' => 'Publication Info',
            'view_info' => 'View Info',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['status_id' => 'id']);
    }
}
