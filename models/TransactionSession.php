<?php

namespace core\models;

use Yii;

/**
 * This is the model class for table "transaction_session".
 *
 * @property string $id
 * @property string $user_ordered
 * @property string $business_id
 * @property string $note
 * @property int $total_price
 * @property string $created_at
 * @property string $user_created
 * @property string $updated_at
 * @property string $user_updated
 * @property bool $is_closed
 * @property int $total_amount
 *
 * @property TransactionItem[] $transactionItems
 * @property Business $business
 * @property User $userOrdered
 * @property User $userCreated
 * @property User $userUpdated
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
            [['user_ordered', 'business_id'], 'required'],
            [['note'], 'string'],
            [['total_price', 'total_amount'], 'default', 'value' => null],
            [['total_price', 'total_amount'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['is_closed'], 'boolean'],
            [['id', 'user_ordered', 'business_id', 'user_created', 'user_updated'], 'string', 'max' => 32],
            [['id'], 'unique'],
            [['business_id'], 'exist', 'skipOnError' => true, 'targetClass' => Business::className(), 'targetAttribute' => ['business_id' => 'id']],
            [['user_ordered'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_ordered' => 'id']],
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
            'user_ordered' => Yii::t('app', 'User Ordered'),
            'business_id' => Yii::t('app', 'Business ID'),
            'note' => Yii::t('app', 'Note'),
            'total_price' => Yii::t('app', 'Total Price'),
            'created_at' => Yii::t('app', 'Created At'),
            'user_created' => Yii::t('app', 'User Created'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'user_updated' => Yii::t('app', 'User Updated'),
            'is_closed' => Yii::t('app', 'Is Closed'),
            'total_amount' => Yii::t('app', 'Total Amount'),
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
    public function getUserOrdered()
    {
        return $this->hasOne(User::className(), ['id' => 'user_ordered']);
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
