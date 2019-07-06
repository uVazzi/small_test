<?php

namespace common\models\domains;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "operation".
 *
 * @property int $id
 * @property int $assessment
 * @property int $create_at
 * @property string $duration
 * @property int $type
 * @property int $target
 * @property int $user_id
 *
 * @property User $user
 */
class Operation extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'operation';
    }

    /** Формирует create_at при создании действия
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['create_at'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['assessment', 'create_at', 'user_id'], 'required'],
            [['assessment', 'create_at', 'type', 'target', 'user_id'], 'integer'],
            [['assessment'], 'integer', 'min' => 1, 'max' => 10],
            [['duration'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'assessment' => 'Assessment',
            'create_at' => 'Create At',
            'duration' => 'Duration',
            'type' => 'Type',
            'target' => 'Target',
            'user_id' => 'User ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
