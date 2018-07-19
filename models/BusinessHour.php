<?php

namespace core\models;

use Yii;

/**
 * This is the model class for table "business_hour".
 *
 * @property int $id
 * @property string $unique_id
 * @property int $business_id
 * @property string $day
 * @property bool $is_open
 * @property string $open_at
 * @property string $close_at
 * @property string $created_at
 * @property int $user_created
 * @property string $updated_at
 * @property int $user_updated
 *
 * @property Business $business
 * @property User $userCreated
 * @property User $userUpdated
 */
class BusinessHour extends \sybase\SybaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'business_hour';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['unique_id', 'business_id', 'day'], 'required'],
            [['business_id', 'user_created', 'user_updated'], 'default', 'value' => null],
            [['business_id', 'user_created', 'user_updated'], 'integer'],
            [['day'], 'string'],
            [['is_open'], 'boolean'],
            [['open_at', 'close_at', 'created_at', 'updated_at'], 'safe'],
            [['unique_id'], 'string', 'max' => 12],
            [['unique_id'], 'unique'],
            [['business_id'], 'exist', 'skipOnError' => true, 'targetClass' => Business::className(), 'targetAttribute' => ['business_id' => 'id']],
            [['user_created'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_created' => 'id']],
            [['user_updated'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_updated' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'unique_id' => Yii::t('app', 'Unique ID'),
            'business_id' => Yii::t('app', 'Business ID'),
            'day' => Yii::t('app', 'Day'),
            'is_open' => Yii::t('app', 'Is Open'),
            'open_at' => Yii::t('app', 'Open At'),
            'close_at' => Yii::t('app', 'Close At'),
            'created_at' => Yii::t('app', 'Created At'),
            'user_created' => Yii::t('app', 'User Created'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'user_updated' => Yii::t('app', 'User Updated'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBusiness()
    {
        return $this->hasOne(Business::className(), ['id' => 'business_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserCreated()
    {
        return $this->hasOne(User::className(), ['id' => 'user_created']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserUpdated()
    {
        return $this->hasOne(User::className(), ['id' => 'user_updated']);
    }
}
