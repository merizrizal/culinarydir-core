<?php

namespace core\models;

use Yii;

/**
 * This is the model class for table "user_level".
 *
 * @property int $id
 * @property string $nama_level
 * @property bool $is_super_admin
 * @property int default_action_crm
 * @property string $keterangan
 * @property string $created_at
 * @property int $user_created
 * @property string $updated_at
 * @property int $user_updated
 * @property int $default_action_cms
 * @property int $default_action_front
 *
 * @property User[] $users
 * @property UserAkses[] $userAkses
 * @property User $userCreated
 * @property User $userUpdated
 * @property UserAppModule $defaultActionCrm
 * @property UserAppModule $defaultActionCms
 * @property UserAppModule $defaultActionFront
 */
class UserLevel extends \sybase\SybaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_level';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nama_level'], 'required'],
            [['is_super_admin'], 'boolean'],
            [['default_action_crm', 'user_created', 'user_updated', 'default_action_cms', 'default_action_front'], 'default', 'value' => null],
            [['default_action_crm', 'user_created', 'user_updated', 'default_action_cms', 'default_action_front'], 'integer'],
            [['keterangan'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['nama_level'], 'string', 'max' => 32],
            [['user_created'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_created' => 'id']],
            [['user_updated'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_updated' => 'id']],
            [['default_action_crm'], 'exist', 'skipOnError' => true, 'targetClass' => UserAppModule::className(), 'targetAttribute' => ['default_action_crm' => 'id']],
            [['default_action_cms'], 'exist', 'skipOnError' => true, 'targetClass' => UserAppModule::className(), 'targetAttribute' => ['default_action_cms' => 'id']],
            [['default_action_front'], 'exist', 'skipOnError' => true, 'targetClass' => UserAppModule::className(), 'targetAttribute' => ['default_action_front' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'nama_level' => Yii::t('app', 'Level Name'),
            'is_super_admin' => Yii::t('app', 'Is Super Admin'),
            'default_action_crm' => Yii::t('app', 'Default Action CRM'),
            'keterangan' => Yii::t('app', 'Note'),
            'created_at' => Yii::t('app', 'Created At'),
            'user_created' => Yii::t('app', 'User Created'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'user_updated' => Yii::t('app', 'User Updated'),
            'default_action_cms' => Yii::t('app', 'Default Action CMS'),
            'default_action_front' => Yii::t('app', 'Default Action Front'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['user_level_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserAkses()
    {
        return $this->hasMany(UserAkses::className(), ['user_level_id' => 'id']);
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
    public function getDefaultActionCrm()
    {
        return $this->hasOne(UserAppModule::className(), ['id' => 'default_action_crm']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDefaultActionCms()
    {
        return $this->hasOne(UserAppModule::className(), ['id' => 'default_action_cms']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDefaultActionFront()
    {
        return $this->hasOne(UserAppModule::className(), ['id' => 'default_action_front']);
    }
}
