<?php

namespace core\models;

use Yii;

/**
 * This is the model class for table "transaction_canceled".
 *
 * @property string $transaction_session_order_id
 * @property string $driver_user_id
 * @property string $created_at
 * @property string $user_created
 * @property string $updated_at
 * @property string $user_updated
 *
 * @property TransactionSession $transactionSessionOrder
 * @property User $driverUser
 * @property User $userCreated
 * @property User $userUpdated
 */
class TransactionCanceled extends \sybase\SybaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'transaction_canceled';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['transaction_session_order_id', 'driver_user_id'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['transaction_session_order_id'], 'string', 'max' => 17],
            [['driver_user_id', 'user_created', 'user_updated'], 'string', 'max' => 32],
            [['transaction_session_order_id'], 'unique'],
            [['transaction_session_order_id'], 'exist', 'skipOnError' => true, 'targetClass' => TransactionSession::className(), 'targetAttribute' => ['transaction_session_order_id' => 'order_id']],
            [['driver_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['driver_user_id' => 'id']],
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
            'transaction_session_order_id' => Yii::t('app', 'Transaction Session Order ID'),
            'driver_user_id' => Yii::t('app', 'Driver User ID'),
            'created_at' => Yii::t('app', 'Created At'),
            'user_created' => Yii::t('app', 'User Created'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'user_updated' => Yii::t('app', 'User Updated'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransactionSessionOrder()
    {
        return $this->hasOne(TransactionSession::className(), ['order_id' => 'transaction_session_order_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDriverUser()
    {
        return $this->hasOne(User::className(), ['id' => 'driver_user_id']);
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
