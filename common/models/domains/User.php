<?php

namespace common\models\domains;

use Yii;
use borales\extensions\phoneInput\PhoneInputValidator;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $name
 * @property string $surname
 * @property string $email
 * @property string $phone_number
 * @property int $rating
 * @property int $create_at
 * @property int $status_id
 *
 * @property Operation[] $operations
 * @property Status $status
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /** Формирует create_at при создании пользователя
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
            [['name', 'surname', 'email', 'phone_number', 'create_at', 'status_id'], 'required'],
            [['rating', 'create_at', 'status_id'], 'integer'],
            [['name', 'surname'], 'string', 'max' => 50],
            ['email', 'email'],
            [['phone_number'], PhoneInputValidator::className()], // Валидация номеров в федеральном формате
            [['email', 'phone_number'], 'unique'],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => Status::className(), 'targetAttribute' => ['status_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'surname' => 'Surname',
            'email' => 'Email',
            'phone_number' => 'Phone Number',
            'rating' => 'Rating',
            'create_at' => 'Create At',
            'status_id' => 'Status ID',
            'moreSeven' => 'От 7',
            'lessSeven' => 'От 7',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOperations()
    {
        return $this->hasMany(Operation::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(Status::className(), ['id' => 'status_id']);
    }

    /** Возвращает дату последнего действия в Timestamp
     * @param $id
     * @return bool|mixed
     */
    public function getTimeLastOperation($id)
    {
        $modelOperation = Operation::find()->andWhere(['user_id' => $id])->orderBy(['create_at' => SORT_DESC])->one();
        if (!empty($modelOperation->create_at)) {
            return $modelOperation->create_at;
        } else {
            return false;
        }
    }

    /**  Возвращает значение moreSeven (количество действий пользователя с оценкой не ниже 7)
     * @return int
     */
    public function getMoreSeven(){
        $operation = Operation::find()
            ->where(['user_id' => $this->id])
            ->andWhere(['between', 'assessment',7, 10])
            ->asArray(true)
            ->all();
        return count($operation);
    }

    /**  Возвращает значение lessSeven (количество действий пользователя с оценкой ниже 7)
     * @return int
     */
    public function getLessSeven(){
        $operation = Operation::find()
            ->where(['user_id' => $this->id])
            ->andWhere(['between', 'assessment',0, 6])
            ->asArray(true)
            ->all();
        return count($operation);
    }
}
