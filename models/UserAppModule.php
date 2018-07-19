<?php

namespace core\models;

use Yii;

/**
 * This is the model class for table "user_app_module".
 *
 * @property int $id
 * @property string $sub_program
 * @property string $nama_module
 * @property string $module_action
 * @property string $created_at
 * @property int $user_created
 * @property string $updated_at
 * @property int $user_updated
 *
 * @property UserAkses[] $userAkses
 * @property User $userCreated
 * @property User $userUpdated
 * @property UserLevel[] $userLevels
 * @property UserLevel[] $userLevels0
 * @property UserLevel[] $userLevels1
 */
class UserAppModule extends \sybase\SybaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_app_module';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sub_program', 'nama_module', 'module_action'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['user_created', 'user_updated'], 'default', 'value' => null],
            [['user_created', 'user_updated'], 'integer'],
            [['guest_can_access'], 'boolean'],
            [['sub_program', 'nama_module', 'module_action'], 'string', 'max' => 128],
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
            'sub_program' => Yii::t('app', 'Sub Program'),
            'nama_module' => Yii::t('app', 'Module Name'),
            'module_action' => Yii::t('app', 'Module Action'),
            'created_at' => Yii::t('app', 'Created At'),
            'user_created' => Yii::t('app', 'User Created'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'user_updated' => Yii::t('app', 'User Updated'),
            'guest_can_access' => Yii::t('app', 'Guest Can Access'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserAkses()
    {
        return $this->hasMany(UserAkses::className(), ['user_app_module_id' => 'id']);
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
    public function getUserLevels()
    {
        return $this->hasMany(UserLevel::className(), ['default_action_crm' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserLevels0()
    {
        return $this->hasMany(UserLevel::className(), ['default_action_cms' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserLevels1()
    {
        return $this->hasMany(UserLevel::className(), ['default_action_front' => 'id']);
    }
}
