<?php

namespace core\models;


/**
 * This is the model class for table "registry_driver".
 *
 * @property string $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $phone
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
 * @property string $other_driver
 * @property bool $is_criteria_passed
 * @property string $created_at
 * @property string $user_created
 * @property string $updated_at
 * @property string $user_updated
 * @property string $application_driver_id
 * @property int $application_driver_counter
 * @property string $user_in_charge
 *
 * @property ApplicationDriver $applicationDriver
 * @property District $district
 * @property User $userCreated
 * @property User $userUpdated
 * @property User $userInCharge
 * @property RegistryDriverAttachment[] $registryDriverAttachments
 */
class RegistryDriver extends \sybase\SybaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'registry_driver';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['first_name', 'phone', 'district_id', 'no_ktp', 'no_sim', 'date_birth', 'motor_brand', 'motor_type', 'emergency_contact_name', 'emergency_contact_phone', 'emergency_contact_address', 'number_plate', 'stnk_expired', 'application_driver_id'], 'required'],
            [['date_birth', 'stnk_expired', 'created_at', 'updated_at'], 'safe'],
            [['emergency_contact_address'], 'string'],
            [['is_criteria_passed'], 'boolean'],
            [['email'], 'email'],
            [['application_driver_counter'], 'default', 'value' => null],
            [['application_driver_counter'], 'integer'],
            [['id', 'district_id', 'emergency_contact_name', 'user_created', 'user_updated', 'application_driver_id', 'user_in_charge'], 'string', 'max' => 32],
            [['first_name', 'last_name', 'phone', 'emergency_contact_phone'], 'string', 'max' => 16],
            [['email'], 'string', 'max' => 64],
            [['no_ktp', 'no_sim'], 'string', 'max' => 19],
            [['motor_brand', 'motor_type'], 'string', 'max' => 30],
            [['number_plate'], 'string', 'max' => 10],
            [['other_driver'], 'string', 'max' => 20],
            [['id'], 'unique'],
            [['application_driver_id'], 'exist', 'skipOnError' => true, 'targetClass' => ApplicationDriver::className(), 'targetAttribute' => ['application_driver_id' => 'id']],
            [['district_id'], 'exist', 'skipOnError' => true, 'targetClass' => District::className(), 'targetAttribute' => ['district_id' => 'id']],
            [['user_created'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_created' => 'id']],
            [['user_updated'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_updated' => 'id']],
            [['user_in_charge'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_in_charge' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => \Yii::t('app', 'ID'),
            'first_name' => \Yii::t('app', 'First Name'),
            'last_name' => \Yii::t('app', 'Last Name'),
            'email' => \Yii::t('app', 'Email'),
            'phone' => \Yii::t('app', 'Phone'),
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
            'other_driver' => \Yii::t('app', 'Other Driver'),
            'is_criteria_passed' => \Yii::t('app', 'Is Criteria Passed'),
            'created_at' => \Yii::t('app', 'Created At'),
            'user_created' => \Yii::t('app', 'User Created'),
            'updated_at' => \Yii::t('app', 'Updated At'),
            'user_updated' => \Yii::t('app', 'User Updated'),
            'application_driver_id' => \Yii::t('app', 'Application Driver ID'),
            'application_driver_counter' => \Yii::t('app', 'Application Driver Counter'),
            'user_in_charge' => \Yii::t('app', 'User In Charge'),
            'userInCharge.full_name' => \Yii::t('app', 'User In Charge'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicationDriver()
    {
        return $this->hasOne(ApplicationDriver::className(), ['id' => 'application_driver_id']);
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserInCharge()
    {
        return $this->hasOne(User::className(), ['id' => 'user_in_charge']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRegistryDriverAttachments()
    {
        return $this->hasMany(RegistryDriverAttachment::className(), ['registry_driver_id' => 'id']);
    }
}
