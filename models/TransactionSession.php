<?php

namespace core\models;

use Yii;

/**
 * This is the model class for table "transaction_session".
 *
 * @property int $id
 * @property string $customer_name
 * @property string $note
 * @property int $total_price
 * @property string $created_at
 * @property int $user_created
 * @property string $updated_at
 * @property int $user_updated
 * @property int $user_ordered
 * @property bool $is_closed
 * @property int $business_id
 *
 * @property TransactionItem[] $transactionItems
 * @property Business $business
 * @property User $userCreated
 * @property User $userUpdated
 * @property User $userOrdered
 */
class TransactionSession extends \sybase\SybaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'transaction_session';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['note'], 'string'],
            [['total_price', 'user_created', 'user_updated', 'user_ordered', 'business_id'], 'default', 'value' => null],
            [['total_price', 'user_created', 'user_updated', 'user_ordered', 'business_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['user_ordered', 'business_id'], 'required'],
            [['is_closed'], 'boolean'],
            [['customer_name'], 'string', 'max' => 64],
            [['business_id'], 'exist', 'skipOnError' => true, 'targetClass' => Business::className(), 'targetAttribute' => ['business_id' => 'id']],
            [['user_created'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_created' => 'id']],
            [['user_updated'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_updated' => 'id']],
            [['user_ordered'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_ordered' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'customer_name' => Yii::t('app', 'Customer Name'),
            'note' => Yii::t('app', 'Note'),
            'total_price' => Yii::t('app', 'Total Price'),
            'created_at' => Yii::t('app', 'Created At'),
            'user_created' => Yii::t('app', 'User Created'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'user_updated' => Yii::t('app', 'User Updated'),
            'user_ordered' => Yii::t('app', 'User Ordered'),
            'is_closed' => Yii::t('app', 'Is Closed'),
            'business_id' => Yii::t('app', 'Business ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransactionItems()
    {
        return $this->hasMany(TransactionItem::className(), ['transaction_session_id' => 'id']);
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserOrdered()
    {
        return $this->hasOne(User::className(), ['id' => 'user_ordered']);
    }
}
