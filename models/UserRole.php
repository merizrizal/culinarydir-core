<?php

namespace core\models;

/**
 * This is the model class for table "user_role".
 *
 * @property string $id
 * @property string $user_id
 * @property string $user_level_id
 * @property string $unique_id
 * @property string $created_at
 * @property string $user_created
 * @property string $updated_at
 * @property string $user_updated
 * @property bool $is_active
 *
 * @property User $user
 * @property User $userCreated
 * @property User $userUpdated
 * @property UserLevel $userLevel
 */
class UserRole extends \sybase\SybaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_role';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'user_level_id', 'unique_id'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['is_active'], 'boolean'],
            [['id', 'user_id', 'user_level_id', 'user_created', 'user_updated'], 'string', 'max' => 32],
            [['unique_id'], 'string', 'max' => 65],
            [['unique_id'], 'unique'],
            [['id'], 'unique'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['user_created'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_created' => 'id']],
            [['user_updated'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_updated' => 'id']],
            [['user_level_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserLevel::className(), 'targetAttribute' => ['user_level_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => \Yii::t('app', 'ID'),
            'user_id' => \Yii::t('app', 'User ID'),
            'user_level_id' => \Yii::t('app', 'User Level ID'),
            'unique_id' => \Yii::t('app', 'Unique ID'),
            'created_at' => \Yii::t('app', 'Created At'),
            'user_created' => \Yii::t('app', 'User Created'),
            'updated_at' => \Yii::t('app', 'Updated At'),
            'user_updated' => \Yii::t('app', 'User Updated'),
            'is_active' => \Yii::t('app', 'Is Active'),
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserLevel()
    {
        return $this->hasOne(UserLevel::className(), ['id' => 'user_level_id']);
    }
}