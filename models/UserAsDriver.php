<?php

namespace core\models;

use Yii;

/**
 * This is the model class for table "user_as_driver".
 *
 * @property string $user_id
 * @property string $coordinate
 * @property bool $is_online
 * @property int $total_cash
 * @property string $socket_id
 * @property string $created_at
 * @property string $user_created
 * @property string $updated_at
 * @property string $user_updated
 *
 * @property User $user
 * @property User $userCreated
 * @property User $userUpdated
 */
class UserAsDriver extends \sybase\SybaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_as_driver';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['is_online'], 'boolean'],
            [['total_cash'], 'default', 'value' => null],
            [['total_cash'], 'integer'],
            [['socket_id'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['user_id', 'user_created', 'user_updated'], 'string', 'max' => 32],
            [['coordinate'], 'string', 'max' => 64],
            [['user_id'], 'unique'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
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
            'user_id' => Yii::t('app', 'User ID'),
            'coordinate' => Yii::t('app', 'Coordinate'),
            'is_online' => Yii::t('app', 'Is Online'),
            'total_cash' => Yii::t('app', 'Total Cash'),
            'socket_id' => Yii::t('app', 'Socket ID'),
            'created_at' => Yii::t('app', 'Created At'),
            'user_created' => Yii::t('app', 'User Created'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'user_updated' => Yii::t('app', 'User Updated'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
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
