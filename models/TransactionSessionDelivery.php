<?php

namespace core\models;

use Yii;

/**
 * This is the model class for table "transaction_session_delivery".
 *
 * @property string $transaction_session_id
 * @property string $driver_id
 * @property double $total_distance
 * @property int $total_delivery_fee
 * @property string $image
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
class TransactionSessionDelivery extends \sybase\SybaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'transaction_session_delivery';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['transaction_session_id', 'driver_id', 'total_distance', 'total_delivery_fee'], 'required'],
            [['total_distance'], 'number'],
            [['total_delivery_fee'], 'default', 'value' => null],
            [['total_delivery_fee'], 'integer'],
            [['image'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['transaction_session_id', 'driver_id', 'user_created', 'user_updated'], 'string', 'max' => 32],
            [['transaction_session_id'], 'unique'],
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
            'transaction_session_id' => Yii::t('app', 'Transaction Session ID'),
            'driver_id' => Yii::t('app', 'Driver ID'),
            'total_distance' => Yii::t('app', 'Total Distance'),
            'total_delivery_fee' => Yii::t('app', 'Total Delivery Fee'),
            'image' => Yii::t('app', 'Image'),
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
