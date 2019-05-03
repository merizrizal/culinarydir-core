<?php

namespace core\models;


/**
 * This is the model class for table "business_promo".
 *
 * @property string $id
 * @property string $business_id
 * @property string $title
 * @property string $short_description
 * @property string $description
 * @property string $image
 * @property string $date_start
 * @property string $date_end
 * @property bool $not_active
 * @property string $created_at
 * @property string $user_created
 * @property string $updated_at
 * @property string $user_updated
 *
 * @property Business $business
 * @property User $userCreated
 * @property User $userUpdated
 */
class BusinessPromo extends \sybase\SybaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'business_promo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['business_id', 'title', 'short_description', 'description'], 'required'],
            [['short_description', 'description', 'image'], 'string'],
            [['date_start', 'date_end', 'created_at', 'updated_at'], 'safe'],
            [['not_active'], 'boolean'],
            [['id', 'business_id', 'user_created', 'user_updated'], 'string', 'max' => 32],
            [['title'], 'string', 'max' => 64],
            [['id'], 'unique'],
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
            'id' => \Yii::t('app', 'ID'),
            'business_id' => \Yii::t('app', 'Business ID'),
            'title' => \Yii::t('app', 'Title'),
            'short_description' => \Yii::t('app', 'Short Description'),
            'description' => \Yii::t('app', 'Description'),
            'image' => \Yii::t('app', 'Image'),
            'date_start' => \Yii::t('app', 'Date Start'),
            'date_end' => \Yii::t('app', 'Date End'),
            'not_active' => \Yii::t('app', 'Not Active'),
            'created_at' => \Yii::t('app', 'Created At'),
            'user_created' => \Yii::t('app', 'User Created'),
            'updated_at' => \Yii::t('app', 'Updated At'),
            'user_updated' => \Yii::t('app', 'User Updated'),
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
