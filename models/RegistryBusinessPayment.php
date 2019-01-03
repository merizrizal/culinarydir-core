<?php

namespace core\models;

use Yii;

/**
 * This is the model class for table "registry_business_payment".
 *
 * @property int $id
 * @property string $unique_id
 * @property int $registry_business_id
 * @property int $payment_method_id
 * @property bool $is_active
 * @property string $created_at
 * @property int $user_created
 * @property string $updated_at
 * @property int $user_updated
 * @property string $note
 *
 * @property PaymentMethod $paymentMethod
 * @property RegistryBusiness $registryBusiness
 * @property User $userCreated
 * @property User $userUpdated
 */
class RegistryBusinessPayment extends \sybase\SybaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'registry_business_payment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['unique_id', 'registry_business_id', 'payment_method_id'], 'required'],
            [['registry_business_id', 'payment_method_id', 'user_created', 'user_updated'], 'default', 'value' => null],
            [['registry_business_id', 'payment_method_id', 'user_created', 'user_updated'], 'integer'],
            [['is_active'], 'boolean'],
            [['created_at', 'updated_at'], 'safe'],
            [['note'], 'string'],
            [['unique_id'], 'string', 'max' => 15],
            [['unique_id'], 'unique'],
            [['payment_method_id'], 'exist', 'skipOnError' => true, 'targetClass' => PaymentMethod::className(), 'targetAttribute' => ['payment_method_id' => 'id']],
            [['registry_business_id'], 'exist', 'skipOnError' => true, 'targetClass' => RegistryBusiness::className(), 'targetAttribute' => ['registry_business_id' => 'id']],
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
            'registry_business_id' => Yii::t('app', 'Registry Business ID'),
            'payment_method_id' => Yii::t('app', 'Payment Method ID'),
            'is_active' => Yii::t('app', 'Is Active'),
            'created_at' => Yii::t('app', 'Created At'),
            'user_created' => Yii::t('app', 'User Created'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'user_updated' => Yii::t('app', 'User Updated'),
            'note' => Yii::t('app', 'Note'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPaymentMethod()
    {
        return $this->hasOne(PaymentMethod::className(), ['id' => 'payment_method_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRegistryBusiness()
    {
        return $this->hasOne(RegistryBusiness::className(), ['id' => 'registry_business_id']);
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
