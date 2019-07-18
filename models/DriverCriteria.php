<?php

namespace core\models;

use Yii;

/**
 * This is the model class for table "driver_criteria".
 *
 * @property string $id
 * @property string $person_as_driver_id
 * @property string $criteria_name
 * @property string $type
 * @property string $created_at
 * @property string $user_created
 * @property string $updated_at
 * @property string $user_updated
 *
 * @property PersonAsDriver $personAsDriver
 * @property User $userCreated
 * @property User $userUpdated
 */
class DriverCriteria extends \sybase\SybaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'driver_criteria';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'person_as_driver_id', 'criteria_name', 'type'], 'required'],
            [['type'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['id', 'person_as_driver_id', 'user_created', 'user_updated'], 'string', 'max' => 32],
            [['criteria_name'], 'string', 'max' => 50],
            [['id'], 'unique'],
            [['person_as_driver_id'], 'exist', 'skipOnError' => true, 'targetClass' => PersonAsDriver::className(), 'targetAttribute' => ['person_as_driver_id' => 'person_id']],
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
            'id' => \Yii::t('app', 'ID'),
            'person_as_driver_id' => \Yii::t('app', 'Person As Driver ID'),
            'criteria_name' => \Yii::t('app', 'Criteria Name'),
            'type' => \Yii::t('app', 'Type'),
            'created_at' => \Yii::t('app', 'Created At'),
            'user_created' => \Yii::t('app', 'User Created'),
            'updated_at' => \Yii::t('app', 'Updated At'),
            'user_updated' => \Yii::t('app', 'User Updated'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPersonAsDriver()
    {
        return $this->hasOne(PersonAsDriver::className(), ['person_id' => 'person_as_driver_id']);
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
