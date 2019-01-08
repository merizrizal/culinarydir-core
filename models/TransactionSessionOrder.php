<?php

namespace core\models;

use Yii;

/**
 * This is the model class for table "transaction_session_order".
 *
 * @property int $id
 * @property int $transaction_session_id
 * @property int $payment_method_id
 * @property int $delivery_method_id
 * @property string $created_at
 * @property int $user_created
 * @property string $updated_at
 * @property int $user_updated
 *
 * @property DeliveryMethod $deliveryMethod
 * @property PaymentMethod $paymentMethod
 * @property TransactionSession $transactionSession
 * @property User $userCreated
 * @property User $userUpdated
 */
class TransactionSessionOrder extends \sybase\SybaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'transaction_session_order';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['transaction_session_id', 'payment_method_id', 'delivery_method_id'], 'required'],
            [['transaction_session_id', 'payment_method_id', 'delivery_method_id', 'user_created', 'user_updated'], 'default', 'value' => null],
            [['transaction_session_id', 'payment_method_id', 'delivery_method_id', 'user_created', 'user_updated'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['delivery_method_id'], 'exist', 'skipOnError' => true, 'targetClass' => DeliveryMethod::className(), 'targetAttribute' => ['delivery_method_id' => 'id']],
            [['payment_method_id'], 'exist', 'skipOnError' => true, 'targetClass' => PaymentMethod::className(), 'targetAttribute' => ['payment_method_id' => 'id']],
            [['transaction_session_id'], 'exist', 'skipOnError' => true, 'targetClass' => TransactionSession::className(), 'targetAttribute' => ['transaction_session_id' => 'id']],
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
            'transaction_session_id' => Yii::t('app', 'Transaction Session ID'),
            'payment_method_id' => Yii::t('app', 'Payment Methods'),
            'delivery_method_id' => Yii::t('app', 'Delivery Methods'),
            'created_at' => Yii::t('app', 'Created At'),
            'user_created' => Yii::t('app', 'User Created'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'user_updated' => Yii::t('app', 'User Updated'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDeliveryMethod()
    {
        return $this->hasOne(DeliveryMethod::className(), ['id' => 'delivery_method_id']);
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
    public function getTransactionSession()
    {
        return $this->hasOne(TransactionSession::className(), ['id' => 'transaction_session_id']);
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
