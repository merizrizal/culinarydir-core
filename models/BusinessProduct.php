<?php

namespace core\models;

use Yii;

/**
 * This is the model class for table "business_product".
 *
 * @property int $id
 * @property int $business_id
 * @property string $name
 * @property string $description
 * @property int $price
 * @property string $image
 * @property bool $not_active
 * @property string $created_at
 * @property int $user_created
 * @property string $updated_at
 * @property int $user_updated
 *
 * @property Business $business
 * @property User $userCreated
 * @property User $userUpdated
 */
class BusinessProduct extends \sybase\SybaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'business_product';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['business_id', 'name', 'price'], 'required'],
            [['business_id', 'price', 'user_created', 'user_updated'], 'default', 'value' => null],
            [['business_id', 'price', 'user_created', 'user_updated'], 'integer'],
            [['description'], 'string'],
            [['not_active'], 'boolean'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 64],
            [['image'], 'string', 'max' => 128],
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
            'business_id' => Yii::t('app', 'Business ID'),
            'name' => Yii::t('app', 'Name'),
            'description' => Yii::t('app', 'Description'),
            'price' => Yii::t('app', 'Price'),
            'image' => Yii::t('app', 'Image'),
            'not_active' => Yii::t('app', 'Not Active'),
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
