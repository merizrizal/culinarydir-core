<?php

namespace core\models;


/**
 * This is the model class for table "status_approval_driver_action".
 *
 * @property string $id
 * @property string $status_approval_driver_id
 * @property string $name
 * @property string $url
 * @property string $created_at
 * @property string $user_created
 * @property string $updated_at
 * @property string $user_updated
 *
 * @property LogStatusApprovalDriverAction[] $logStatusApprovalDriverActions
 * @property StatusApprovalDriver $statusApprovalDriver
 * @property User $userCreated
 * @property User $userUpdated
 * @property StatusApprovalDriverRequireAction[] $statusApprovalDriverRequireActions
 */
class StatusApprovalDriverAction extends \sybase\SybaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'status_approval_driver_action';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status_approval_driver_id', 'name', 'url'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['id', 'user_created', 'user_updated'], 'string', 'max' => 32],
            [['status_approval_driver_id'], 'string', 'max' => 7],
            [['name', 'url'], 'string', 'max' => 64],
            [['id'], 'unique'],
            [['status_approval_driver_id'], 'exist', 'skipOnError' => true, 'targetClass' => StatusApprovalDriver::className(), 'targetAttribute' => ['status_approval_driver_id' => 'id']],
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
            'status_approval_driver_id' => \Yii::t('app', 'Status Approval Driver ID'),
            'name' => \Yii::t('app', 'Name'),
            'url' => \Yii::t('app', 'Url'),
            'created_at' => \Yii::t('app', 'Created At'),
            'user_created' => \Yii::t('app', 'User Created'),
            'updated_at' => \Yii::t('app', 'Updated At'),
            'user_updated' => \Yii::t('app', 'User Updated'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLogStatusApprovalDriverActions()
    {
        return $this->hasMany(LogStatusApprovalDriverAction::className(), ['status_approval_driver_action_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatusApprovalDriver()
    {
        return $this->hasOne(StatusApprovalDriver::className(), ['id' => 'status_approval_driver_id']);
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
    public function getStatusApprovalDriverRequireActions()
    {
        return $this->hasMany(StatusApprovalDriverRequireAction::className(), ['status_approval_driver_action_id' => 'id']);
    }
}