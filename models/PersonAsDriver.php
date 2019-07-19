<?php

namespace core\models;

/**
 * This is the model class for table "person_as_driver".
 *
 * @property string $person_id
 * @property string $district_id
 * @property string $no_ktp
 * @property string $no_sim
 * @property string $date_birth
 * @property string $motor_brand
 * @property string $motor_type
 * @property string $emergency_contact_name
 * @property string $emergency_contact_phone
 * @property string $emergency_contact_address
 * @property string $number_plate
 * @property string $stnk_expired
 * @property string $created_at
 * @property string $user_created
 * @property string $updated_at
 * @property string $user_updated
 * @property string $other_driver
 *
 * @property DriverCriteria[] $driverCriterias
 * @property District $district
 * @property Person $person
 * @property User $userCreated
 * @property User $userUpdated
 */

class PersonAsDriver extends \sybase\SybaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'person_as_driver';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['person_id', 'district_id', 'no_ktp', 'no_sim', 'date_birth', 'motor_brand', 'motor_type', 'emergency_contact_name', 'emergency_contact_phone', 'emergency_contact_address', 'number_plate', 'stnk_expired'], 'required'],
            [['date_birth', 'stnk_expired', 'created_at', 'updated_at'], 'safe'],
            [['emergency_contact_address'], 'string'],
            [['person_id', 'district_id', 'emergency_contact_name', 'user_created', 'user_updated'], 'string', 'max' => 32],
            [['no_ktp', 'no_sim'], 'string', 'max' => 19],
            [['motor_brand', 'motor_type'], 'string', 'max' => 30],
            [['emergency_contact_phone'], 'string', 'max' => 16],
            [['number_plate'], 'string', 'max' => 10],
            [['other_driver'], 'string', 'max' => 20],
            [['person_id'], 'unique'],
            [['district_id'], 'exist', 'skipOnError' => true, 'targetClass' => District::className(), 'targetAttribute' => ['district_id' => 'id']],
            [['person_id'], 'exist', 'skipOnError' => true, 'targetClass' => Person::className(), 'targetAttribute' => ['person_id' => 'id']],
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
            'person_id' => \Yii::t('app', 'Person ID'),
            'district_id' => \Yii::t('app', 'District ID'),
            'no_ktp' => \Yii::t('app', 'No Ktp'),
            'no_sim' => \Yii::t('app', 'No Sim'),
            'date_birth' => \Yii::t('app', 'Date Birth'),
            'motor_brand' => \Yii::t('app', 'Motor Brand'),
            'motor_type' => \Yii::t('app', 'Motor Type'),
            'emergency_contact_name' => \Yii::t('app', 'Emergency Contact Name'),
            'emergency_contact_phone' => \Yii::t('app', 'Emergency Contact Phone'),
            'emergency_contact_address' => \Yii::t('app', 'Emergency Contact Address'),
            'number_plate' => \Yii::t('app', 'Number Plate'),
            'stnk_expired' => \Yii::t('app', 'Stnk Expired'),
            'created_at' => \Yii::t('app', 'Created At'),
            'user_created' => \Yii::t('app', 'User Created'),
            'updated_at' => \Yii::t('app', 'Updated At'),
            'user_updated' => \Yii::t('app', 'User Updated'),
            'other_driver' => \Yii::t('app', 'Other Driver'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDriverCriterias()
    {
        return $this->hasMany(DriverCriteria::className(), ['person_as_driver_id' => 'person_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDistrict()
    {
        return $this->hasOne(District::className(), ['id' => 'district_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPerson()
    {
        return $this->hasOne(Person::className(), ['id' => 'person_id']);
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