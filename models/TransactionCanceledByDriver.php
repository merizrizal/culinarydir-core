<?php

namespace core\models;

use Yii;

/**
 * This is the model class for table "transaction_canceled_by_driver".
 *
 * @property string $id
 * @property string $transaction_session_id
 * @property string $order_id
 * @property string $driver_id
 * @property string $created_at
 * @property string $user_created
 * @property string $updated_at
 * @property string $user_updated
 *
 * @property TransactionSession $transactionSession
 * @property User $driver
 * @property User $userCreated
 * @property User $userUpdated
 */
class TransactionCanceledByDriver extends \sybase\SybaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'transaction_canceled_by_driver';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['transaction_session_id', 'order_id', 'driver_id'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['id', 'transaction_session_id', 'driver_id', 'user_created', 'user_updated'], 'string', 'max' => 32],
            [['order_id'], 'string', 'max' => 17],
            [['id'], 'unique'],
            [['transaction_session_id'], 'exist', 'skipOnError' => true, 'targetClass' => TransactionSession::className(), 'targetAttribute' => ['transaction_session_id' => 'id']],
            [['driver_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['driver_id' => 'id']],
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
            'order_id' => Yii::t('app', 'Order ID'),
            'driver_id' => Yii::t('app', 'Driver ID'),
            'created_at' => Yii::t('app', 'Created At'),
            'user_created' => Yii::t('app', 'User Created'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'user_updated' => Yii::t('app', 'User Updated'),
        ];
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
    public function getDriver()
    {
        return $this->hasOne(User::className(), ['id' => 'driver_id']);
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
