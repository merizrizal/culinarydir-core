<?php

namespace core\models;

use Yii;

/**
 * This is the model class for table "registry_business".
 *
 * @property int $id
 * @property int $membership_type_id
 * @property string $name
 * @property string $unique_name
 * @property string $email
 * @property string $phone1
 * @property string $phone2
 * @property string $phone3
 * @property string $address_type
 * @property string $address
 * @property string $address_info
 * @property int $city_id
 * @property int $district_id
 * @property int $village_id
 * @property string $coordinate
 * @property string $status
 * @property int $user_in_charge
 * @property string $created_at
 * @property int $user_created
 * @property string $updated_at
 * @property int $user_updated
 * @property int $price_min
 * @property int $price_max
 *
 * @property City $city
 * @property District $district
 * @property MembershipType $membershipType
 * @property User $userInCharge
 * @property User $userCreated
 * @property User $userUpdated
 * @property Village $village
 * @property RegistryBusinessApprovalLog $registryBusinessApprovalLog
 * @property RegistryBusinessCategory[] $registryBusinessCategories
 * @property RegistryBusinessFacility[] $registryBusinessFacilities
 * @property RegistryBusinessImage[] $registryBusinessImages
 * @property RegistryBusinessHour[] $registryBusinessHours
 * @property RegistryBusinessProductCategory[] $registryBusinessProductCategories
 */
class RegistryBusiness extends \sybase\SybaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'registry_business';
    }

    public function scenarios() {

        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_CREATE] = [
            'membership_type_id', 'name', 'unique_name', 'email', 'phone1', 'phone2', 'phone3', 'address_type', 'address', 'address_info',
            'city_id', 'district_id', 'village_id', 'coordinate', 'status', 'user_in_charge', 'created_at', 'user_created', 'updated_at', 'user_updated',
            'price_min', 'price_max'
        ];

        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['membership_type_id', 'name', 'unique_name', 'address_type', 'address', 'city_id', 'district_id', 'village_id', 'coordinate'], 'required'],
            [['membership_type_id', 'city_id', 'district_id', 'village_id', 'user_in_charge', 'user_created', 'user_updated'], 'default', 'value' => null],
            [['membership_type_id', 'city_id', 'district_id', 'village_id', 'user_in_charge', 'user_created', 'user_updated', 'price_min', 'price_max'], 'integer'],
            [['address_type', 'address', 'address_info', 'status'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'email'], 'string', 'max' => 48],
            [['unique_name', 'coordinate'], 'string', 'max' => 64],
            [['phone1', 'phone2', 'phone3'], 'string', 'max' => 16],
            [['unique_name'], 'unique', 'on' => self::SCENARIO_CREATE],
            [['email'], 'email'],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => City::className(), 'targetAttribute' => ['city_id' => 'id']],
            [['district_id'], 'exist', 'skipOnError' => true, 'targetClass' => District::className(), 'targetAttribute' => ['district_id' => 'id']],
            [['membership_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => MembershipType::className(), 'targetAttribute' => ['membership_type_id' => 'id']],
            [['user_in_charge'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_in_charge' => 'id']],
            [['user_created'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_created' => 'id']],
            [['user_updated'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_updated' => 'id']],
            [['village_id'], 'exist', 'skipOnError' => true, 'targetClass' => Village::className(), 'targetAttribute' => ['village_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'membership_type_id' => Yii::t('app', 'Membership Type ID'),
            'name' => Yii::t('app', 'Name'),
            'unique_name' => Yii::t('app', 'Unique Name'),
            'email' => Yii::t('app', 'Email'),
            'phone1' => Yii::t('app', 'Phone 1'),
            'phone2' => Yii::t('app', 'Phone 2'),
            'phone3' => Yii::t('app', 'Phone 3'),
            'address_type' => Yii::t('app', 'Address Type'),
            'address' => Yii::t('app', 'Address'),
            'address_info' => Yii::t('app', 'Address Info'),
            'city_id' => Yii::t('app', 'City ID'),
            'district_id' => Yii::t('app', 'District ID'),
            'village_id' => Yii::t('app', 'Village ID'),
            'coordinate' => Yii::t('app', 'Coordinate'),
            'status' => Yii::t('app', 'Status'),
            'user_in_charge' => Yii::t('app', 'User In Charge'),
            'created_at' => Yii::t('app', 'Created At'),
            'user_created' => Yii::t('app', 'User Created'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'user_updated' => Yii::t('app', 'User Updated'),
            'price_min' => Yii::t('app', 'Price Min'),
            'price_max' => Yii::t('app', 'Price Max'),
            'membershipType.name' => Yii::t('app', 'Membership Type'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(City::className(), ['id' => 'city_id']);
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
    public function getMembershipType()
    {
        return $this->hasOne(MembershipType::className(), ['id' => 'membership_type_id']);
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
    public function getVillage()
    {
        return $this->hasOne(Village::className(), ['id' => 'village_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRegistryBusinessApprovalLog()
    {
        return $this->hasOne(RegistryBusinessApprovalLog::className(), ['registry_business_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRegistryBusinessCategories()
    {
        return $this->hasMany(RegistryBusinessCategory::className(), ['registry_business_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRegistryBusinessFacilities()
    {
        return $this->hasMany(RegistryBusinessFacility::className(), ['registry_business_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRegistryBusinessImages()
    {
        return $this->hasMany(RegistryBusinessImage::className(), ['registry_business_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRegistryBusinessHours()
    {
        return $this->hasMany(RegistryBusinessHour::className(), ['registry_business_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRegistryBusinessProductCategories()
    {
        return $this->hasMany(RegistryBusinessProductCategory::className(), ['registry_business_id' => 'id']);
    }
}
