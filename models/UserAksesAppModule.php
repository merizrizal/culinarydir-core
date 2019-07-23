<?php

namespace core\models;

/**
 * This is the model class for table "user_akses_app_module".
 *
 * @property string $id
 * @property string $unique_id
 * @property string $user_id
 * @property string $user_app_module_id
 * @property string $created_at
 * @property string $user_created
 * @property string $updated_at
 * @property string $user_updated
 * @property bool $is_active
 * @property array $used_by_user_role
 *
 * @property User $user
 * @property User $userCreated
 * @property User $userUpdated
 * @property UserAppModule $userAppModule
 */
class UserAksesAppModule extends \sybase\SybaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_akses_app_module';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['unique_id', 'user_id', 'user_app_module_id'], 'required'],
            [['created_at', 'updated_at', 'used_by_user_role'], 'safe'],
            [['is_active'], 'boolean'],
            [['id', 'user_id', 'user_app_module_id', 'user_created', 'user_updated'], 'string', 'max' => 32],
            [['unique_id'], 'string', 'max' => 65],
            [['unique_id'], 'unique'],
            [['id'], 'unique'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['user_created'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_created' => 'id']],
            [['user_updated'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_updated' => 'id']],
            [['user_app_module_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserAppModule::className(), 'targetAttribute' => ['user_app_module_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => \Yii::t('app', 'ID'),
            'unique_id' => \Yii::t('app', 'Unique ID'),
            'user_id' => \Yii::t('app', 'User ID'),
            'user_app_module_id' => \Yii::t('app', 'User App Module ID'),
            'created_at' => \Yii::t('app', 'Created At'),
            'user_created' => \Yii::t('app', 'User Created'),
            'updated_at' => \Yii::t('app', 'Updated At'),
            'user_updated' => \Yii::t('app', 'User Updated'),
            'is_active' => \Yii::t('app', 'Is Active'),
            'used_by_user_role' => \Yii::t('app', 'Used By User Role'),
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
    public function getUserAppModule()
    {
        return $this->hasOne(UserAppModule::className(), ['id' => 'user_app_module_id']);
    }
}
