<?php

namespace core\models;

use Yii;

/**
 * This is the model class for table "registry_business_hour_additional".
 *
 * @property int $id
 * @property string $unique_id
 * @property int $registry_business_hour_id
 * @property string $day
 * @property bool $is_open
 * @property string $open_at
 * @property string $close_at
 * @property string $created_at
 * @property int $user_created
 * @property string $updated_at
 * @property int $user_updated
 *
 * @property RegistryBusinessHour $registryBusinessHour
 * @property User $userCreated
 * @property User $userUpdated
 */
class RegistryBusinessHourAdditional extends \sybase\SybaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'registry_business_hour_additional';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['unique_id', 'registry_business_hour_id', 'day'], 'required'],
            [['registry_business_hour_id', 'user_created', 'user_updated'], 'default', 'value' => null],
            [['registry_business_hour_id', 'user_created', 'user_updated'], 'integer'],
            [['day'], 'string'],
            [['is_open'], 'boolean'],
            [['open_at', 'close_at', 'created_at', 'updated_at'], 'safe'],
            [['unique_id'], 'string', 'max' => 14],
            [['unique_id'], 'unique'],
            [['registry_business_hour_id'], 'exist', 'skipOnError' => true, 'targetClass' => RegistryBusinessHour::className(), 'targetAttribute' => ['registry_business_hour_id' => 'id']],
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
            'registry_business_hour_id' => Yii::t('app', 'Registry Business Hour ID'),
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
    public function getRegistryBusinessHour()
    {
        return $this->hasOne(RegistryBusinessHour::className(), ['id' => 'registry_business_hour_id']);
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
