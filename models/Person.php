<?php

namespace core\models;

use Yii;

/**
 * This is the model class for table "person".
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $phone
 * @property int $city_id
 * @property string $address
 * @property string $about_me
 * @property string $created_at
 * @property int $user_created
 * @property string $updated_at
 * @property int $user_updated
 *
 * @property City $city
 * @property User $userCreated
 * @property User $userUpdated
 * @property RegistryBusinessContactPerson[] $registryBusinessContactPeople
 * @property UserPerson $userPerson
 */
class Person extends \sybase\SybaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'person';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['first_name', 'last_name', 'email', 'phone'], 'required'],
            [['city_id', 'user_created', 'user_updated'], 'default', 'value' => null],
            [['city_id', 'user_created', 'user_updated'], 'integer'],
            [['address', 'about_me'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['first_name', 'last_name', 'phone'], 'string', 'max' => 16],
            [['email'], 'string', 'max' => 64],
            [['email'], 'email'],
            [['email'], 'unique'],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => City::className(), 'targetAttribute' => ['city_id' => 'id']],
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
            'first_name' => Yii::t('app', 'First Name'),
            'last_name' => Yii::t('app', 'Last Name'),
            'email' => Yii::t('app', 'Email'),
            'phone' => Yii::t('app', 'Phone'),
            'city_id' => Yii::t('app', 'City ID'),
            'address' => Yii::t('app', 'Address'),
            'about_me' => Yii::t('app', 'About Me'),
            'created_at' => Yii::t('app', 'Created At'),
            'user_created' => Yii::t('app', 'User Created'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'user_updated' => Yii::t('app', 'User Updated'),
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
    public function getRegistryBusinessContactPeople()
    {
        return $this->hasMany(RegistryBusinessContactPerson::className(), ['person_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserPerson()
    {
        return $this->hasOne(UserPerson::className(), ['person_id' => 'id']);
    }
}
