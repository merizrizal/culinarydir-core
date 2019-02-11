<?php

namespace core\models;

use Yii;

/**
 * This is the model class for table "promo_item".
 *
 * @property string $id
 * @property string $promo_id
 * @property string $user_claimed
 * @property string $business_claimed
 * @property int $amount
 * @property bool $not_active
 * @property string $created_at
 * @property string $user_created
 * @property string $updated_at
 * @property string $user_updated
 *
 * @property Business $businessClaimed
 * @property Promo $promo
 * @property User $userClaimed
 * @property User $userCreated
 * @property User $userUpdated
 */
class PromoItem extends \sybase\SybaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'promo_item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['promo_id', 'amount'], 'required'],
            [['amount'], 'default', 'value' => null],
            [['amount'], 'integer'],
            [['not_active'], 'boolean'],
            [['created_at', 'updated_at'], 'safe'],
            [['id'], 'string', 'max' => 14],
            [['promo_id', 'user_claimed', 'business_claimed', 'user_created', 'user_updated'], 'string', 'max' => 32],
            [['id'], 'unique'],
            [['business_claimed'], 'exist', 'skipOnError' => true, 'targetClass' => Business::className(), 'targetAttribute' => ['business_claimed' => 'id']],
            [['promo_id'], 'exist', 'skipOnError' => true, 'targetClass' => Promo::className(), 'targetAttribute' => ['promo_id' => 'id']],
            [['user_claimed'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_claimed' => 'id']],
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
            'promo_id' => Yii::t('app', 'Promo ID'),
            'user_claimed' => Yii::t('app', 'User Claimed'),
            'business_claimed' => Yii::t('app', 'Business Claimed'),
            'amount' => Yii::t('app', 'Amount'),
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
    public function getBusinessClaimed()
    {
        return $this->hasOne(Business::className(), ['id' => 'business_claimed']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPromo()
    {
        return $this->hasOne(Promo::className(), ['id' => 'promo_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserClaimed()
    {
        return $this->hasOne(User::className(), ['id' => 'user_claimed']);
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
